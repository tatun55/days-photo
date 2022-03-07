<?php

namespace App\Http\Controllers;

use App\Jobs\StoreImageJob;
use App\Jobs\StoreLineImageMessageToS3Job;
use App\Models\Photo;
use App\Models\ImageSet;
use App\Models\User;
use App\Models\Album;
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
            if (config('app.env') !== 'production') {
                \Log::info(json_encode($event, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            }

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
                case 'message':
                    switch ($event->message->type) {
                        case 'image':
                            $this->verifySignature($request);
                            switch ($event->source->type) {
                                case 'user':
                                    $this->isRegisted($event->source->userId) && $this->postedPhotoFromUser($event);
                                    break;
                                case 'group':
                                    $this->isRegisted($event->source->userId) && $this->postedPhotoFromGroup($event);
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
                Photo::where('album_id', $data->id)->delete();
                $message = "✅ 保存前のアルバムが削除されました。";
                $bot = $this->initBot();
                $bot->replyText($event->replyToken, $message);
                break;
            case 'add':
                $message = "追加したい画像を送信してください✨";
                $bot = $this->initBot();
                $bot->replyText($event->replyToken, $message);
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
        $photoId = Photo::where('album_id', $albumId)->withTrashed()->first()->id;
        $album->cover = \Storage::disk('s3')->url("/{$albumId}/{$photoId}/s.jpg");
        $album->save();

        // who can acess the album
        $album->users()->syncWithoutDetaching($event->source->userId);

        // dispatch store image jobs
        $jobs = [];
        $photos = Photo::where('album_id', $albumId)->get();
        foreach ($photos as $photo) {
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
                            'type' => 'postback',
                            'label' => '📓 部屋に飾れるミニアルバム化',
                            'data' => "action=album&id={$albumId}",
                            'text' => "ミニアルバム",
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
                    [
                        'type' => 'action',
                        'action' => [
                            'type' => 'postback',
                            'label' => '✖️ なにもしない',
                            'data' => "action=nothing&id={$albumId}",
                            'text' => "なにもしない",
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
            $multiMessage = new MultiMessageBuilder();
            $text = "アカウント登録が完了しました 🎉\n\n『days.』は、新しいタイプの ”かんたんフォト管理” サービス。\n\n✅ 機能①\nこのアカウントに画像をまとめて送信すると、”ずっと残るアルバム”が作成されます✨\n\n✅ 機能②\nかんたん操作で ”部屋にかざれるミニアルバム” をポチッと注文✨\n\nほかにも様々な便利機能を準備中です（現在α版）";
            $multiMessage->add(new TextMessageBuilder($text));
            $bot->replyMessage($event->replyToken, $multiMessage);
        }
    }

    public function isRegisted($userId)
    {
        return User::where('id', $userId)->exists();
    }

    public function postedPhotoFromUser($event)
    {
        // 作成途中のAlbumを取得、なければ作成
        $album = Album::firstOrCreate(
            [
                'user_id' => $event->source->userId,
                'status' => 'default',
            ],
            [
                'id' => (string) \Str::uuid(),
            ]
        );

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
            }
        } else {
            $album->increment('total', 1);
            $index = $album->total;
            $this->replyForPostedPhoto($album->total, $album->id, $event->replyToken);
        }

        // 投稿された画像情報を保存
        $photo = Photo::create([
            'id' => (string) \Str::uuid(),
            'album_id' => $album->id,
            'user_id' => $event->source->userId,
            'message_id' => $event->message->id,
            'index' => $index,
        ]);
    }

    public function postedPhotoFromGroup($event)
    {
        $album = Album::query()
            ->where('group_id', $event->source->groupId)
            ->where('status', 'default')
            ->first();

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
            'user_id' => $event->source->userId,
            'group_id' => $event->source->groupId,
            'message_id' => $event->message->id,
            'index' => $index,
        ]);

        // TODO: Registed GroupMembers attach AlbumUser,PhotoUser
        // User::findMany($groupMembers);
        $album->users()->syncWithoutDetaching($event->source->userId);
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
            'text' => "画像を受信しました（トータル {$total}枚）",
            'quickReply' => [
                'items' => [
                    [
                        'type' => 'action',
                        'action' => [
                            'type' => 'postback',
                            'label' => '💎 ずっと残る保存',
                            'data' => "action=save&id={$albumId}",
                            'text' => "保存",
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
                            'type' => 'postback',
                            'label' => '❌ キャンセル',
                            'data' => "action=cancel&id={$albumId}",
                            'text' => "キャンセル",
                        ]
                    ],
                    [
                        'type' => 'action',
                        'action' => [
                            'type' => 'postback',
                            'label' => '🖼️ 画像を追加',
                            'data' => "action=add&id={$albumId}",
                            'text' => "画像を追加",
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
        $multiMessage->add(new TextMessageBuilder("こんにちは。\n\n新しいタイプの “かんたんフォト管理サービス” 『days.』です。\n\nこのアカウントは、フォト管理に役立つ機能を提供します。"));
        $multiMessage = $this->addTermsMessage($multiMessage);
        $bot->replyMessage($event->replyToken, $multiMessage);
    }

    public function joined($event)
    {
        $bot = $this->initBot();
        $multiMessage = new MultiMessageBuilder();
        // $multiMessage->add(new TextMessageBuilder("こんにちは。\n\n新しいタイプの “かんたんフォト管理サービス” 『days.』です。\n\n『days.』を友だち登録すると、フォト管理に役立つ機能を提供します。\n\nグループメンバーが『days.』を登録していない場合、そのメンバーのアクションには一切関与しません。\n\nサービスを利用したいときは、下のリンクから友だち登録をお願いします。"));
        $multiMessage->add(new TextMessageBuilder("こんにちは。\n\n新しいタイプの “かんたんフォト管理サービス” 『days.』です。\n\n『days.』をグループに招待すると、トークでシェアされた写真を ”ずっと残る” & ”いつでも見れる” ように保存します。\n\nLINEのアルバムとして保存された写真や『days.』に登録していないメンバーの投稿した写真は保存されません。\n\nサービスを利用したいときは、下のリンクから友だち登録をお願いします。"));
        $multiMessage->add(new TextMessageBuilder('https://lin.ee/O6NF5rk'));
        $bot->replyMessage($event->replyToken, $multiMessage);

        $groupSummaryJson = $bot->getGroupSummary($event->source->groupId);
        $groupSummary = json_decode($groupSummaryJson, false);
        LineGroup::updateOrCreate([
            [
                'line_group_id' => $groupSummary->groupId
            ],
            [
                'name' => $groupSummary->groupId,
                'picture_url' => $groupSummary->pictureUrl,
            ]
        ]);
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
        $buttonTemplage = new ButtonTemplateBuilder("以下を必ずご確認いただき、同意できる場合のみユーザー登録にお進みください。", $actions);
        $templateMessage = new TemplateMessageBuilder('テンプレートタイトル', $buttonTemplage);
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
}