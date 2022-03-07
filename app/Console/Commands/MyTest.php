<?php

namespace App\Console\Commands;

use App\Models\Album;
use Illuminate\Console\Command;

class MyTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:myTest';

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
        $ids = Album::orderBy('created_at', 'desc')->first()->images()->pluck('id');
        $urls = [];
        foreach ($ids as $key => $value) {
            $urls[] = \Storage::disk('s3')->url("o/{$value}.jpg");
        }
        dump($urls);
    }
}