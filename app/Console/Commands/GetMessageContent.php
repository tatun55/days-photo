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
        $httpClient = new CurlHTTPClient(config('services.line.messaging_api.access_token'));
        $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.messaging_api.channel_secret')]);
        $response = $bot->getMessageContent('15614895789526');
        dump($response->getHeaders());
    }
}