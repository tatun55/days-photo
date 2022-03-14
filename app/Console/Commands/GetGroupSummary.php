<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetGroupSummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getGroupSummary';

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
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(config('services.line.messaging_api.access_token'));
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => config('services.line.messaging_api.channel_secret')]);
        $response = $bot->getGroupSummary('C5929593a295f2ccbb04a198be5836600');
        dump($response);
    }
}