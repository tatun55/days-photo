<?php

namespace App\Console\Commands;

use App\Models\Album;
use App\Models\User;
use Illuminate\Console\Command;

class WhereHas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:WhereHas';

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
        $user = User::first();
        $photos = Album::orderBy('created_at', 'desc')->first()->photos();
        $dump = $photos->whereHas('users', function ($q) use ($user) {
            return $q->where('user_id', $user->id)->where('is_archived', false);
        });
        dump($dump->get()->toArray());
    }
}