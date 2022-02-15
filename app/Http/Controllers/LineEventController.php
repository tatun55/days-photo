<?php

namespace App\Http\Controllers;

use App\Jobs\StoreLineImageMessageToS3Job;
use App\Models\LineGroup;
use App\Models\LineGroupUser;
use App\Models\PostedImage;
use App\Models\LineUser;
use App\Models\LineUserLineGroup;
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
                case 'follow':
                    $this->followed($event);
                    break;
                case 'unfollow':
                    $this->unfollowed($event);
                    break;
                case 'accountLink':
                    $this->verifySignature($request);
                    $this->accountLinked($event);
                    break;
                case 'join':
                    $this->joined($event);
                    break;
                case 'message':
                    switch ($event->message->type) {
                        case 'image':
                            $this->postedImageFromRegistedUser($event);
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

    public function accountLinked($event)
    {
        if ($event->link->result === 'ok') {
            $bot = $this->initBot();
            $multiMessage = new MultiMessageBuilder();
            $text = "アカウント登録が完了しました 🎉";
            $multiMessage->add(new TextMessageBuilder($text));
            $text = "『days.』は、30秒でアルバムが作れる ”かんたんフォト管理” サービス。\n\n✅ 機能①\nこのアカウントにまとめて画像を送信すると、自動でアルバム・コラージュ画像が作成されます✨";
            $multiMessage->add(new TextMessageBuilder($text));
            $text = "ほかにも様々な便利機能を準備中です（現在、β版）\n\n完成まで、お楽しみに☺️";
            $multiMessage->add(new TextMessageBuilder($text));
            $bot->replyMessage($event->replyToken, $multiMessage);
        }
    }

    public function postedImageFromRegistedUser()
    {
        if (LineUser::where('line_user_id', $event->source->userId)->exists()) {
            $isFromGroup = $event->source->type === 'group';
            $postedImage = PostedImage::create([
                'uuid' => (string) \Str::uuid(),
                'line_user_id' => $event->source->userId,
                'line_group_id' => $isFromGroup ? $event->source->groupId : null,
                'line_message_id' => $event->message->id,
            ]);
            StoreLineImageMessageToS3Job::dispatch($postedImage->id);
            if ($isFromGroup) {
                LineGroupLineUser::firstOrCreate([
                    'line_user_id' => $event->source->userId,
                    'line_group_id' => $event->source->groupId,
                ]);
            }
        }
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
        $multiMessage->add(new TextMessageBuilder("下記のリンクで、スグにサービスに登録できます。\n\n※ 登録の際に、LINEのユーザー名とプロフィール画像が使用されます。\n\nhttps://days.photo/login/line"));
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

    public function initBot()
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