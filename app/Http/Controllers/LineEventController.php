<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class LineEventController extends Controller
{
    public function process(Request $request)
    {
        foreach ($request->events as $event) {
            $event = (object) $event;

            // TODO: delete (This is just for developing)
            \Log::info(json_encode($event, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

            switch ($event->type) {
                case 'follow':
                    $this->replyMultiText($event->replyToken, ["こんにちは。\n\n新しいタイプの 'かんたん写真管理サービス' 『days.』です。\n\nこのアカウントをグループに招待していただくと、写真管理に役立つ機能を提供します。\n\nグループメンバーが『days.』に登録していない場合、そのメンバーのアクションには一切関与しません。\n\n利用規約およびプライバシーポリシーをお読みになり、同意する場合は以下のリンクからユーザー登録をお願いします。\n\n※ 登録の際に、LINEのユーザー名とプロフィール画像が使用されます。", 'https://days.photo/login/line']);
                    break;
                case 'join':
                    $this->replyMultiText($event->replyToken, ["こんにちは。\n\n新しいタイプの 'かんたん写真管理サービス' 『days.』です。\n\n『days.』を友だち登録していただくと、写真管理に役立つ機能を提供します。\n\nグループメンバーが『days.』に登録していない場合、そのメンバーのアクションには一切関与しません。\n\n利用規約およびプライバシーポリシーをお読みになり、同意する場合は以下のリンクから友だち登録をお願いします。", 'https://lin.ee/O6NF5rk']);
                    break;
            }
        }
        return response()->json('ok', 200);
    }

    public function replyMultiText($replyToken, $texts)
    {
        $bot = $this->initBot();
        $multiMessage = new MultiMessageBuilder();
        foreach ($texts as $text) {
            $multiMessage->add(new TextMessageBuilder($text));
        }
        $bot->replyMessage($replyToken, $multiMessage);
    }

    public function replySimpleText($replyToken, $text)
    {
        $bot = $this->initBot();
        $bot->replyText($replyToken, $text);
    }

    public function initBot()
    {
        $httpClient = new CurlHTTPClient(config('services.line.messaging_api.access_token'));
        return new LINEBot($httpClient, ['channelSecret' => config('services.line.messaging_api.channel_secret')]);;
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