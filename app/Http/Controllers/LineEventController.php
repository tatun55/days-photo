<?php

namespace App\Http\Controllers;

use App\Jobs\StoreLineImageMessageToS3Job;
use App\Models\ImageFromUser;
use App\Models\ImageSet;
use App\Models\LineUser;
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
                            $isFromUser = $event->source->type === 'user';
                            if ($isFromUser && $this->isRegisted($event->source->userId)) {
                                $this->postedImageFromUser($event);
                            }
                            break;
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
                // TODO: サイトでみる、名前を変える、デザインタイプ変更、注文する、印刷する、今はなにもしない、を選べる
                $imageSet = ImageSet::find($data->id);
                $imageSet->done = true;
                $imageSet->save();
                $dateStr = Carbon::today()->format('Y年n月j日');
                $message = "✅ アルバム『{$dateStr}に作成』が保存されました。";
                $bot = $this->initBot();
                $bot->replyText($event->replyToken, $message);
                break;
            case 'cancel':
                $imageSet = ImageSet::destroy($data->id);
                ImageFromUser::where('image_set_id', $data->id)->delete();
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

    public function getRawMessageForPostbackedSave($message)
    {
    }

    public function accountLinked($event)
    {
        if ($event->link->result === 'ok') {
            $bot = $this->initBot();
            $multiMessage = new MultiMessageBuilder();
            $text = "アカウント登録が完了しました 🎉";
            $multiMessage->add(new TextMessageBuilder($text));
            $text = "『days.』は、30秒でアルバムが作れる ”かんたんフォト管理” サービス。\n\n✅ 機能①\nこのアカウントにまとめて画像を送信すると、自動でアルバム・コラージュ画像が作成されます✨";
            $multiMessage->add(new TextMessageBuilder($text));
            $text = "ほかにも様々な便利機能を準備中です（現在、β版）";
            $multiMessage->add(new TextMessageBuilder($text));
            $bot->replyMessage($event->replyToken, $multiMessage);
        }
    }

    public function isRegisted($userId)
    {
        return LineUser::where('id', $userId)->exists();
    }

    public function postedImageFromUser($event)
    {
        // 作成途中のImageSetを取得、なければ作成
        $imageSet = ImageSet::firstOrCreate(
            [
                'line_user_id' => $event->source->userId,
                'done' => false,
            ],
            [
                'id' => (string) \Str::uuid(),
                'message_id' => $event->message->id,
            ]
        );

        // 投稿された画像情報を保存
        $imageFromUser = ImageFromUser::create([
            'id' => (string) \Str::uuid(),
            'message_id' => $event->message->id,
            'image_set_id' => $imageSet->id,
        ]);

        // 複数画像の同時送信の最後、もしくは画像の単独送信である場合に、クイックリプライ付き返信を返す
        $isNotLast = isset($event->message->imageSet) && $event->message->imageSet->index !== $event->message->imageSet->total;
        if (!$isNotLast) {
            $bot = $this->initBot();
            $total = ImageFromUser::where('image_set_id', $imageSet->id)->get()->count();
            $rawMessage = $this->getRawMessageForPostedImageFromUser($total, $imageSet);
            $bot->replyMessage($event->replyToken, $rawMessage);
        }
    }

    public function getRawMessageForPostedImageFromUser($total, $imageSet)
    {
        $array = [
            'type' => 'text',
            'text' => "画像を受信しました（トータル {$total}枚）",
            'quickReply' => [
                'items' => [
                    [
                        'type' => 'action',
                        'action' => [
                            'type' => 'postback',
                            'label' => '💾 保存',
                            'data' => "action=save&id={$imageSet->id}",
                            'text' => "保存",
                        ]
                    ],
                    [
                        'type' => 'action',
                        'action' => [
                            'type' => 'postback',
                            'label' => '❌ キャンセル',
                            'data' => "action=cancel&id={$imageSet->id}",
                            'text' => "キャンセル",
                        ]
                    ],
                    [
                        'type' => 'action',
                        'action' => [
                            'type' => 'postback',
                            'label' => '🖼️ 画像を追加',
                            'data' => "action=add&id={$imageSet->id}",
                            'text' => "画像を追加",
                        ]
                    ],
                ]
            ]
        ];
        return new RawMessageBuilder($array);
    }

    public function unfollowed(Type $var = null)
    {
    }

    public function followed($event)
    {
        $bot = $this->initBot();
        $multiMessage = new MultiMessageBuilder();
        $multiMessage->add(new TextMessageBuilder("こんにちは。\n\n新しいタイプの “かんたんフォト管理サービス” 『days.』です。\n\nこのアカウントは、フォト管理に役立つ機能を提供します。"));
        $multiMessage = $this->addTermsMessage($multiMessage);
        $multiMessage->add(new TextMessageBuilder("下記のリンクから、スグにサービスに登録できます。\n\n※ 登録の際に、LINEのユーザー名とプロフィール画像が使用されます。"));
        $multiMessage = $this->addTermsMessage($multiMessage);
        $multiMessage->add(new TextMessageBuilder("https://days.photo/login/line"));
        $bot->replyMessage($event->replyToken, $multiMessage);
    }

    public function joined($event)
    {
        $bot = $this->initBot();
        $multiMessage = new MultiMessageBuilder();
        $multiMessage->add(new TextMessageBuilder("こんにちは。\n\n新しいタイプの 'かんたんフォト管理サービス' 『days.』です。\n\n『days.』を友だち登録すると、フォト管理に役立つ機能を提供します。\n\nただし、グループメンバーが『days.』を登録していない場合、そのメンバーのアクションには一切関与しません。\n\nサービスを使用したい場合は、下のリンクから友だち登録をお願いします。"));
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
        $actions = [
            $terms_button,
            $pp_button
        ];
        $buttonTemplage = new ButtonTemplateBuilder("以下を必ずご確認いただき、ユーザー登録にお進みください。ユーザー登録により規約に同意したとみなされます。", $actions);
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