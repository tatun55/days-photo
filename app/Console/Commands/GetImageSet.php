<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot;

class GetImageSet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getImageSet';

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
        $httpClient = new CurlHTTPClient(config('services.line.messaging_api.access_token'));
        $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.messaging_api.channel_secret')]);
        $res = $bot->getMessageContent('15590933101690');
        $data = $res->getRawBody();
        $type = finfo_buffer(finfo_open(), $data, FILEINFO_EXTENSION);
        dd($type); // string(17) "jpeg/jpg/jpe/jfif"
    }
}