<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        if (config('app.env') !== 'production') {
            $deleteFlag = true && $this->deleteAllS3Files();
            $this->call(MyAccountSeeder::class);
        }
    }

    public function deleteAllS3Files()
    {
        $files = \Storage::disk('s3')->files('/');
        $files = \Storage::disk('s3')->files('/t/');
        \Storage::disk('s3')->delete($files);
        echo "\033[31m\nAll S3 Files are DELETED!\n\n";
    }
}