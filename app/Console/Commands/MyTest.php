<?php

namespace App\Console\Commands;

use App\Models\ImageFromUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MyTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:mytest';

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
        $filePath = storage_path('image_from_user.json');
        $json = file_get_contents($filePath);
        $data = json_decode($json, true);
    }
}