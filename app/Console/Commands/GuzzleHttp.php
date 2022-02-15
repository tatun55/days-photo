<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GuzzleHttp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:guzzleHttp';

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
        $client = new \GuzzleHttp\Client();
        $res = $client->post("https://api.line.me/v2/bot/user/U359c48cffd2121dcb99513ee5fdf43f8/linkToken", [
            'headers' => ['Authorization' => 'Bearer ' . config('services.line.messaging_api.access_token')],
        ]);
        $linkToken = json_decode($res->getBody()->getContents())->linkToken;
        dd($linkToken);
    }
}