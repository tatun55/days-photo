<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class S3FileSystemTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:s3';

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
        $files = \Storage::disk('s3')->files('/');
        $res = \Storage::disk('s3')->delete($files);
        // $res = \Storage::disk('s3')->allFiles('');
        // $res = \Storage::disk('s3')->copy('dev/a7634974-b580-4e32-b409-19e2b41d918b.jpg', 'a7634974-b580-4e32-b409-19e2b41d918b.jpg');
        // $res = \Storage::disk('s3')->deleteDirectory('');
        // $res = \Storage::disk('s3')->get('dev/a7634974-b580-4e32-b409-19e2b41d918b.jpg');
        // dump(\Image::make($res)->exif());
    }
}