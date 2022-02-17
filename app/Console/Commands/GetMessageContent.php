<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class GetMessageContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getMsgContent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $httpClient = new CurlHTTPClient(config('services.line.messaging_api.access_token'));
        // $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.messaging_api.channel_secret')]);
        // // $response = $bot->getMessageContent('15598606786645');
        // $response = $bot->getMessageContent('15599138809517');
        // dump(\Image::make($response->getRawBody())->exif());
        // 画像ファイルのパス
        $img = 'https://days-photo.s3.ap-northeast-1.amazonaws.com/a7634974-b580-4e32-b409-19e2b41d918b.jpg';

        // Exifを取得し、[$exif]に代入する
        $exif = @exif_read_data($img);
        echo '<pre>';
        // 取得したデータを出力する
        var_dump($exif);
        echo '</pre>';
    }
}