<?php

namespace App\Http\Controllers;

use App\Jobs\StoreImageJob;
use App\Jobs\StoreLineImageMessageToS3Job;
use App\Models\Photo;
use App\Models\ImageSet;
use App\Models\User;
use App\Models\Album;
use App\Models\AlbumUser;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\FacadesLog;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\RawMessageBuilder;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Session;
use Throwable;

class LineEventController extends Controller
{
    public function process(Request $request)
    {
        foreach ($request->events as $event) {
            $event = json_decode(json_encode($event), false);

            // TODO: delete (This is just for developing)
            \Log::info(json_encode($event, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

            // TODO: test at here
            // return response()->json('ok', 200);

            switch ($event->type) {
                case 'postback':
                    $this->verifySignature($request) || abort(400);
                    $this->postbacked($event);
                    break;
                case 'follow':
                    $this->followed($event);
                    break;
                case 'unfollow':
                    $this->unfollowed($event);
                    break;
                case 'accountLink':
                    $this->verifySignature($request) || abort(400);
                    $this->accountLinked($event);
                    break;
                case 'join': // getting event when invited to group
                    $this->joined($event);
                    break;
                case 'memberJoined': // getting event when invited to group
                    $this->memberJoined($event);
                    break;
                case 'message':
                    switch ($event->message->type) {
                        case 'image':
                        case 'video':
                            $this->verifySignature($request);
                            switch ($event->source->type) {
                                case 'user':
                                    $this->isRegisted($event->source->userId) && $this->postedPhotoFromUser($event);
                                    break;
                                case 'group':
                                    $this->isRegisted($event->source->userId) && $this->postedPhotoFromGroup($event);
                                    break;
                            }
                            break;
                        case 'text':
                            switch ($event->source->type) {
                                case 'user':
                                    if ($event->message->text === '使い方') {
                                        $this->usage($event);
                                    } else {
                                        $this->usage($event);
                                    }
                                    break;
                            }
                    }
                    break;
            }

            if (config('app.env') !== 'production' && isset($resp)) {
                \Log::info(json_encode($resp, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            }
        }

        return response()->json('ok', 200);
    }

    public function postbacked($event)
    {
        parse_str($event->postback->data, $dataArr);
        $data = (object)$dataArr;
        switch ($data->action) {
            case 'save':
            case 'temporary-save':
                $this->postbackedSave($event, $data->id, $data->action);
                break;
            case 'cancel':
                $album = Album::destroy($data->id);
                $message = "✅ 保存前のアルバムが削除されました。";
                $bot = $this->initBot();
                $bot->replyText($event->replyToken, $message);
                break;
            case 'add':
                $message = "追加したい画像を送信してください✨";
                $bot = $this->initBot();
                $bot->replyText($event->replyToken, $message);
                break;
            case 'upload-completed':
                $album = Album::findOrFail($data->id);
                if ($album->photos()->isNotEmpty()) {
                    $this->replyForPostedPhoto($album->photos()->count(), $album->id, $event->replyToken);
                }
                break;
            case 'start-saving':
                if ($this->isRegisted($event->source->userId)) {

                    $group = Group::find($event->source->groupId);
                    if (!$group) {
                        $summary = $this->getGroupSummary($event->source->groupId);
                        $group = Group::create([
                            'id' => $event->source->groupId,
                            'name' => $summary->groupName,
                            'picture' => $summary->pictureUrl,
                        ]);
                    }
                    User::find($event->source->userId)->groups()->syncWithoutDetaching($event->source->groupId, ['auto_saving' => true]);

                    $bot = $this->initBot();
                    $res = json_decode($bot->getProfile($event->source->userId)->getRawBody());
                    $name = (isset($res->displayName) && $res->displayName)
                        ? $res->displayName
                        : 'ノーネーム';
                    $message = "{$name}さんの「💎ずっと残る保存」が開始されました✨";
                    $bot = $this->initBot();
                    $bot->replyText($event->replyToken, $message);
                } else {
                    $message = "①のボタンから、👤友だち＆ユーザー登録をお願いします✨";
                    $bot = $this->initBot();
                    $bot->replyText($event->replyToken, $message);
                }
                break;
        }
    }

    /**
     * TODO: 以下を選べるようにする
     * - サイトでみる
     * - 名前を変える
     * - デザインタイプ変更
     * - 注文する、印刷する
     * - 今はなにもしない
     */
    public function postbackedSave($event, $albumId, $type)
    {
        $replyToken = $event->replyToken;
        $dateStr = Carbon::today()->format('Y年n月j日');
        $title = "{$dateStr}に作成";
        switch ($type) {
            case 'save':
                $deleteDate = null;
                $message = "✅ アルバム『{$title}』が保存されました。";
                break;
            case 'temporary-save':
                $daysForStore = 14;
                $deleteDate = Carbon::today()->addDays($daysForStore);
                $message = "✅ アルバム『{$title}』が一時保存されました。\n\n保存期間は、{$daysForStore}日間です。";
                break;
        }

        // update Album 
        $album = Album::find($albumId);
        $album->status = 'uploading';
        $album->title = $title;
        $photos = $album->photos()->get();

        $album->cover = \Storage::disk('s3')->url("/{$albumId}/{$photos[0]->id}/s.jpg");
        $album->save();

        // ownership
        $album->users()->syncWithoutDetaching($event->source->userId);
        User::find($event->source->userId)->photos()->syncWithoutDetaching($photos->pluck('id'));

        // dispatch store image jobs
        $jobs = [];
        foreach ($album->photos()->get() as $photo) {
            $jobs[] = new StoreImageJob($photo->id, $photo->message_id);
        }
        $batch = Bus::batch($jobs)
            ->then(function (Batch $batch) use ($albumId) {
                $album = Album::find($albumId);
                $album->status = 'uploaded';
                $album->save();
            })->catch(function (Batch $batch, Throwable $e) {
                Log::error($e->getMessage());
            })->finally(function (Batch $batch) use ($replyToken, $message, $albumId) {
                $this->replyForSavedImage($replyToken, $message, $albumId);
            })->dispatch();
    }

    public function replyForSavedImage($replyToken, $message, $albumId)
    {
        $bot = $this->initBot();
        $array = [
            'type' => 'text',
            'text' => $message,
            'quickReply' => [
                'items' => [
                    [
                        'type' => 'action',
                        'action' => [
                            'type' => 'uri',
                            'label' => '📔 部屋にかざれるミニアルバムにする',
                            'uri' => route('albums.show', [$albumId, 'modal' => 'start']),
                        ]
                    ],
                    [
                        'type' => 'action',
                        'action' => [
                            'type' => 'uri',
                            'label' => '🌐 サイトでみる',
                            'uri' => route('albums.show', $albumId),
                        ]
                    ],
                ]
            ]
        ];
        $rawMessage = new RawMessageBuilder($array);
        $bot->replyMessage($replyToken, $rawMessage);
    }

    public function accountLinked($event)
    {
        if ($event->link->result === 'ok') {
            $bot = $this->initBot();
            // $multiMessage = new MultiMessageBuilder();
            // $text = "アカウント登録が完了しました 🎉\n\n『days.』は、新しいタイプの ”かんたんフォト管理” サービス。\n\n✅ 機能①\nこのアカウントに画像をまとめて送信すると、「💎ずっと残る保存」ができる✨\n\n✅ 機能②\nグループに招待すると、グループでも「💎ずっと残る保存」が可能✨\n\n✅ 機能③\nかんたん操作で「📔部屋にかざれるミニアルバム」をポチッと注文✨\n\nほかにも様々な便利機能を準備中です";
            // $multiMessage->add(new TextMessageBuilder($text));

            $bot = $this->initBot();
            $message = "アカウント登録が完了しました 🎉\n\n『days.』は、新しいタイプの ”かんたんフォト管理” サービス。\n\n✅ 機能①\nこのアカウントに画像をまとめて送信すると、「💎ずっと残る保存」ができる✨\n\n✅ 機能②\nグループに招待すると、グループでも「💎ずっと残る保存」が可能✨\n\n✅ 機能③\nかんたん操作で「📔部屋にかざれるミニアルバム」をポチッと注文✨\n\nほかにも様々な便利機能を準備中です💪";
            $array = [
                'type' => 'text',
                'text' => $message,
                'quickReply' => [
                    'items' => [
                        [
                            'type' => 'action',
                            'action' => [
                                'type' => 'cameraRoll',
                                'label' => '画像を送信する',
                            ]
                        ],
                    ]
                ]
            ];
            $rawMessage = new RawMessageBuilder($array);

            $bot->replyMessage($event->replyToken, $rawMessage);
        }
    }

    public function isRegisted($userId)
    {
        return User::where('id', $userId)->exists();
    }

    public function postedPhotoFromUser($event)
    {
        // 作成途中のAlbumを取得、なければ作成
        $album = Album::where('user_id', $event->source->userId)
            ->where('group_id', null)
            ->where('status', 'default')
            ->first();

        $firstFlag = false;
        if (!$album) {
            $album = Album::create([
                'id' => (string) \Str::uuid(),
                'user_id' => $event->source->userId,
                'group_id' => null,
            ]);
            $firstFlag = true;
        }

        // $album = Album::firstOrCreate(
        //     [
        //         'user_id' => $event->source->userId,
        //         'group_id' => null,
        //         'status' => 'default',
        //     ],
        //     [
        //         'id' => (string) \Str::uuid(),
        //     ]
        // );

        /**
         * ImageSetの序列管理
         * 画像がImageSetとして複数同時投稿される場合、Event受信が順不同になりうる問題
         */
        if (isset($event->message->imageSet)) {
            $imageSetId = $event->message->imageSet->id;
            $imageSetTotal = $event->message->imageSet->total;
            $imageSetIndex = $event->message->imageSet->index;
            $imageSet = ImageSet::firstOrCreate(['id' => $event->message->imageSet->id]);
            $imageSet->increment('count', 1);
            $index = $album->total + $imageSetIndex;
            if ($imageSet->count === $imageSetTotal) {
                $imageSet->delete();
                $album->increment('total', $imageSetTotal);
                $this->replyForPostedPhoto($album->total, $album->id, $event->replyToken);
            } else {
                // 画像の送信が完了して止まった場合（画像受信メッセージとクイックリプライが返ってこない）
                // 送信完了したのに、受信メッセージとボタンが返ってこない場合、こちらをクリック
                // 送信完了時にボタンが表示されないとき用
                if ($firstFlag) { // 最初の画像を受信したとき
                    $this->uploadCompleteBtn($album->id, $event->replyToken);
                }
            }
        } else {
            $album->increment('total', 1);
            $index = $album->total;
            $this->replyForPostedPhoto($album->total, $album->id, $event->replyToken);
        }

        // 投稿された画像情報を保存
        if ($event->message->type === 'image') {
            $photo = Photo::create([
                'id' => (string) \Str::uuid(),
                'album_id' => $album->id,
                'message_id' => $event->message->id,
            ]);
        }
    }

    public function uploadCompleteBtn($albumId, $replyToken)
    {
        $bot = $this->initBot();
        $multiMessage = new MultiMessageBuilder();

        $array = [
            "type" => "template",
            "altText" => "送信完了ボタン",
            "template" => [
                "type" => "buttons",
                "title" => "🖼️ 画像を連続受信中...",
                "text" => "画像送信をキャンセルした場合、保存ボタンが出ません。その場合のみ、下の「送信完了」を押してください",
                "actions" => [
                    [
                        "type" => "postback",
                        "label" => "✅ 送信完了",
                        "data" => "action=upload-completed&id={$albumId}",
                    ],
                ]
            ]
        ];
        $rawMessage = new RawMessageBuilder($array);
        $multiMessage->add($rawMessage);

        $bot->replyMessage($replyToken, $multiMessage);
    }

    public function postedPhotoFromGroup($event)
    {

        $album = Album::query()
            ->where('group_id', $event->source->groupId)
            ->where('status', 'default')
            ->firstOrFail();

        $userId = $event->source->userId;
        $autoSavingFlag = Group::findOrFail($event->source->groupId)
            ->users()
            ->where('user_id', $userId)
            ->where('auto_saving', true)
            ->exists();

        if (!$autoSavingFlag) {
            return;
        }

        if (!$album) {
            $summary = $this->getGroupSummary($event->source->groupId);
            $album = Album::Create([
                'id' => (string) \Str::uuid(),
                'user_id' => $event->source->userId,
                'group_id' => $event->source->groupId,
                'title' => $summary->groupName,
                'cover' => $summary->pictureUrl,
            ]);
        }

        /**
         * ImageSetの序列管理
         * 画像がImageSetとして複数同時投稿される場合、Event受信が順不同になりうる問題
         */

        if (isset($event->message->imageSet)) {
            $imageSetId = $event->message->imageSet->id;
            $imageSetTotal = $event->message->imageSet->total;
            $imageSetIndex = $event->message->imageSet->index;
            $imageSet = ImageSet::firstOrCreate(['id' => $event->message->imageSet->id,]);
            $imageSet->increment('count', 1);
            $index = $album->total + $imageSetIndex;
            if ($imageSet->count === $imageSetTotal) {
                $imageSet->delete();
                $album->increment('total', $imageSetTotal);
            }
        } else {
            $album->increment('total', 1);
            $index = $album->total;
        }

        // 投稿された画像情報を保存
        $photo = Photo::create([
            'id' => (string) \Str::uuid(),
            'album_id' => $album->id,
            'message_id' => $event->message->id,
        ]);

        // who can access this album and photo
        $groupUserIds = Group::find($event->source->groupId)->users()->pluck('users.id'); // users in this group
        $album->users()->syncWithoutDetaching($groupUserIds); // users in this group can access this album
        $photo->users()->syncWithoutDetaching($groupUserIds); // users in this group can access this photo

        StoreImageJob::dispatch($photo->id, $photo->message_id);
    }

    public function getGroupMemberIds($groupId)
    {
        $bot = $this->initBot();
        $res = $bot->getGroupMemberIds($groupId);
        return json_decode($res->getRawBody(), false); //object
    }

    public function getGroupSummary($groupId)
    {
        $bot = $this->initBot();
        $res = $bot->getGroupSummary($groupId);
        return json_decode($res->getRawBody(), false); //object
    }

    public function replyForPostedPhoto($total, $albumId, $replyToken)
    {
        $bot = $this->initBot();
        $array = [
            'type' => 'text',
            // 'text' => "✅ 画像を受信しました（トータル {$total}枚）",
            'text' => "✅ 画像を受信しました",
            'quickReply' => [
                'items' => [
                    [
                        'type' => 'action',
                        'action' => [
                            'type' => 'postback',
                            'label' => '💎 ずっと残る保存',
                            'data' => "action=save&id={$albumId}",
                        ]
                    ],
                    // [
                    //     'type' => 'action',
                    //     'action' => [
                    //         'type' => 'postback',
                    //         'label' => '🌠 スグ消える保存',
                    //         'data' => "action=temporary-save&id={$albumId}",
                    //         'text' => "一時保存",
                    //     ]
                    // ],
                    [
                        'type' => 'action',
                        'action' => [
                            'type' => 'cameraRoll',
                            'label' => '画像を追加',
                        ]
                    ],
                    // [
                    //     'type' => 'action',
                    //     'action' => [
                    //         'type' => 'postback',
                    //         'label' => '🖼️ 画像を追加',
                    //         'data' => "action=add&id={$albumId}",
                    //         'text' => "画像を追加",
                    //     ]
                    // ],
                    [
                        'type' => 'action',
                        'action' => [
                            'type' => 'postback',
                            'label' => '❌ キャンセル',
                            'data' => "action=cancel&id={$albumId}",
                        ]
                    ],
                ]
            ]
        ];
        $rawMessage = new RawMessageBuilder($array);
        $bot->replyMessage($replyToken, $rawMessage);
    }

    public function unfollowed()
    {
    }

    public function followed($event)
    {
        $bot = $this->initBot();
        $multiMessage = new MultiMessageBuilder();
        // $multiMessage->add(new TextMessageBuilder("こんにちは、かんたんフォト管理サービスの『days.』です。\n\nこのアカウントは、｢💎ずっと残る保存｣や｢📔手間なしミニアルバム作成｣など、フォト管理に役立つ機能を提供します。"));
        $multiMessage->add(new TextMessageBuilder("こんにちは、かんたんフォト管理サービスの『days.』です。\n\nこのアカウントは、フォト管理に役立つ機能を提供します。"));
        $multiMessage = $this->addTermsMessage($multiMessage);
        $bot->replyMessage($event->replyToken, $multiMessage);
    }

    public function joined($event)
    {
        $bot = $this->initBot();
        $multiMessage = new MultiMessageBuilder();

        $array = [
            'type' => 'text',
            'text' => "こんにちは、かんたんフォト管理の『days.』です。\n\n下のボタン①→②の手順で、画像の「💎ずっと残る保存」が開始できます。\n※いつでも停止できます\n\n❗注意\nLINEのアルバム機能で投稿された画像は保存されません。",
        ];
        $rawMessage = new RawMessageBuilder($array);
        $multiMessage->add($rawMessage);

        $array = [
            "type" => "template",
            "altText" => "This is a buttons template",
            "template" => [
                "type" => "buttons",
                "text" => "登録済なら②のみ",
                "actions" => [
                    [
                        "type" => "uri",
                        "label" => "①友だち&ユーザー登録👤",
                        "uri" => "https://lin.ee/O6NF5rk"
                    ],
                    [
                        "type" => "postback",
                        "label" => "②ずっと残る保存開始💎",
                        "data" => "action=start-saving"
                    ],
                ]
            ]
        ];
        $rawMessage = new RawMessageBuilder($array);
        $multiMessage->add($rawMessage);

        $bot->replyMessage($event->replyToken, $multiMessage);
    }

    public function memberJoined($event)
    {
        $array = [
            'type' => 'text',
            'text' => "こんにちは、かんたんフォト管理の『days.』です。\n\n下のボタン①→②の手順で、トーク内画像の「💎ずっと残る保存」が開始できます。\n※メンバーそれぞれが行う必要があります\n※いつでも停止できます\n\n❗注意\nLINEのアルバム機能で投稿された画像は保存されません。",
        ];
        $rawMessage = new RawMessageBuilder($array);
        $multiMessage->add($rawMessage);

        $array = [
            "type" => "template",
            "altText" => "This is a buttons template",
            "template" => [
                "type" => "buttons",
                "text" => "登録済なら②のみ",
                "actions" => [
                    [
                        "type" => "uri",
                        "label" => "①友だち&ユーザー登録👤",
                        "uri" => "https://lin.ee/O6NF5rk"
                    ],
                    [
                        "type" => "postback",
                        "label" => "②ずっと残る保存開始💎",
                        "data" => "action=start-saving"
                    ],
                ]
            ]
        ];
        $rawMessage = new RawMessageBuilder($array);
        $multiMessage->add($rawMessage);
        $bot->replyMessage($event->replyToken, $multiMessage);

        // foreach ($event->joined->members as $joinedMember) {
        //     $bot = $this->initBot();
        //     $multiMessage = new MultiMessageBuilder();
        //     if ($this->isRegisted($joinedMember->userId)) {
        //         $array = [
        //             "type" => "template",
        //             "altText" => "This is a buttons template",
        //             "template" => [
        //                 "type" => "buttons",
        //                 "text" => "こんにちは。下のボタンから ｢💎ずっと残る保存｣ を開始できます",
        //                 "actions" => [
        //                     [
        //                         "type" => "postback",
        //                         "label" => "ずっと残る保存開始💎",
        //                         "data" => "action=start-saving"
        //                     ],
        //                 ]
        //             ]
        //         ];
        //         $rawMessage = new RawMessageBuilder($array);
        //         $multiMessage->add($rawMessage);
        //     } else {

        //         $array = [
        //             'type' => 'text',
        //             'text' => "こんにちは、かんたんフォト管理の『days.』です。\n\n下のボタン①→②の手順で、トーク内画像の「💎ずっと残る保存」が開始できます。\n※メンバーそれぞれが行う必要があります\n※いつでも停止できます\n\n❗注意\nLINEのアルバム機能で投稿された画像は保存されません。",
        //         ];
        //         $rawMessage = new RawMessageBuilder($array);
        //         $multiMessage->add($rawMessage);

        //         $array = [
        //             "type" => "template",
        //             "altText" => "This is a buttons template",
        //             "template" => [
        //                 "type" => "buttons",
        //                 "text" => "登録済なら②のみ",
        //                 "actions" => [
        //                     [
        //                         "type" => "uri",
        //                         "label" => "①友だち&ユーザー登録👤",
        //                         "uri" => "https://lin.ee/O6NF5rk"
        //                     ],
        //                     [
        //                         "type" => "postback",
        //                         "label" => "②ずっと残る保存開始💎",
        //                         "data" => "action=start-saving"
        //                     ],
        //                 ]
        //             ]
        //         ];
        //         $rawMessage = new RawMessageBuilder($array);
        //         $multiMessage->add($rawMessage);
        //     }
        //     $bot->replyMessage($event->replyToken, $multiMessage);
        // }
    }

    public function addTermsMessage($multiMessage)
    {
        $terms_button = new UriTemplateActionBuilder('利用規約', 'https://days.photo/terms');
        $pp_button = new UriTemplateActionBuilder('プライバシーポリシー', 'https://days.photo/pp');
        $regist_button = new UriTemplateActionBuilder('ユーザー登録', 'https://days.photo/login/line');
        $actions = [
            $terms_button,
            $pp_button,
            $regist_button
        ];
        $buttonTemplage = new ButtonTemplateBuilder("下記ご確認いただき、同意できる場合に「ユーザー登録」にお進みください。", $actions);
        $templateMessage = new TemplateMessageBuilder('ユーザー登録をお願いします', $buttonTemplage);
        $multiMessage->add($templateMessage);
        return $multiMessage;
    }

    public function initBot(): LINEBot
    {
        $httpClient = new CurlHTTPClient(config('services.line.messaging_api.access_token'));
        return new LINEBot($httpClient, ['channelSecret' => config('services.line.messaging_api.channel_secret')]);
    }

    public function verifySignature($request)
    {
        $signatureRequested = $request->header('x-line-signature');

        if (empty($signatureRequested)) {
            return false;
        };
        $httpRequestBody = $request->getContent();
        $channelSecret = config('services.line.messaging_api.channel_secret');
        $hash = hash_hmac('sha256', $httpRequestBody, $channelSecret, true);
        $signature = base64_encode($hash);
        return $signatureRequested === $signature;
    }

    public function usage($event)
    {
        $bot = $this->initBot();
        $multiMessage = new MultiMessageBuilder();

        $message = "『days.』は、新しいタイプの ”かんたんフォト管理” サービス。\n\n✅ 機能①\nこのアカウントに画像をまとめて送信すると、「💎ずっと残る保存」ができる✨\n\n✅ 機能②\nグループに招待すると、グループでも「💎ずっと残る保存」が可能✨\n\n✅ 機能③\nかんたん操作で「📔部屋にかざれるミニアルバム」をポチッと注文✨\n\nほかにも様々な便利機能を準備中です💪";
        $array = [
            'type' => 'text',
            'text' => $message,
        ];
        $rawMessage = new RawMessageBuilder($array);
        $multiMessage->add($rawMessage);

        $array = [
            "type" => "template",
            "altText" => "α版の説明書(PDF)",
            "template" => [
                "type" => "buttons",
                "text" => "現在のバージョンはα版です。詳しい使い方は、下の説明書(PDF)からご覧いただけます。",
                "actions" => [
                    [
                        "type" => "uri",
                        "label" => "α版の説明書(PDF)",
                        "uri" => "https://days-photo.s3.ap-northeast-1.amazonaws.com/days.+%E3%80%9C%E3%81%8B%E3%82%93%E3%81%9F%E3%82%93%E3%83%95%E3%82%A9%E3%83%88%E7%AE%A1%E7%90%86%E3%80%9C+%CE%B1%E7%89%88%E4%BD%BF%E3%81%84%E6%96%B9.pdf"
                    ],
                ]
            ],
            'quickReply' => [
                'items' => [
                    [
                        'type' => 'action',
                        'action' => [
                            'type' => 'cameraRoll',
                            'label' => '画像を送信する',
                        ]
                    ],
                ]
            ]
        ];
        $rawMessage = new RawMessageBuilder($array);
        $multiMessage->add($rawMessage);

        $bot->replyMessage($event->replyToken, $multiMessage);
    }
}