<?php

namespace App\Console\Commands;

use App\Models\Album;
use App\Models\User;
use Illuminate\Console\Command;

class CopyImageFilesAtOrderCompleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CopyImageFilesAtOrderCompleted';

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
        $user = User::find('U359c48cffd2121dcb99513ee5fdf43f8');
        $cartItems = $user->cartItems()->get();
        $albumIds = $cartItems->pluck('album_id');
        foreach ($albumIds as $albumId) {
            $photosOrdered = Album::find($albumId)->photos()
                ->whereHas('users', function ($q) use ($user) {
                    $q->where('user_id', $user->id)->where('is_archived', false);
                })
                ->orderBy('created_at')
                ->get();
            dump($photosOrdered->toArray());
        }
    }
}