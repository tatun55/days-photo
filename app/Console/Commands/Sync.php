<?php

namespace App\Console\Commands;

use App\Models\Album;
use App\Models\User;
use Illuminate\Console\Command;

class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Sync';

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
        // User::find('U359c48cffd2121dcb99513ee5fdf43f8')->albums()->syncWithoutDetaching('fbb1fe1e-fb63-4a3d-ad6f-5226df7b0f58');
        // User::find('U359c48cffd2121dcb99513ee5fdf43f8')->albums()->syncWithPivotValues('fbb1fe1e-fb63-4a3d-ad6f-5226df7b0f58', ['created_at' => now()]);
        dump(Album::all()->toArray());
    }
}