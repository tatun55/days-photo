<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class NewHttpFacade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:newHttpFacade';

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
        $res = Http::withHeaders(['Authorization' => 'Bearer ' . config('services.line.messaging_api.access_token')])
            ->post("https://api.line.me/v2/bot/user/U359c48cffd2121dcb99513ee5fdf43f8/linkToken");
        $linkToken = $res->object()->linkToken;
        dd($linkToken);
    }
}