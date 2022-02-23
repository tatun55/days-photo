<?php

namespace Database\Seeders;

use App\Models\ImageFromUser;
use App\Models\LineUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MyAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LineUser::create([
            "id" => 'U359c48cffd2121dcb99513ee5fdf43f8',
            "name" => "たかい",
            "avatar" => "https://profile.line-scdn.net/0hGgGb2ZXcGEh6GzeHQORnH0ZeFiUNNR4AAilUfl0SFCsFI1tME30CKVceFChXeVdLFi9VKAxMRXEE"
        ]);

        // // ImageFromUser data
        // $filePath = storage_path('image_from_user.json');
        // $json = file_get_contents($filePath);
        // $data = json_decode($json, true);
        // DB::table('image_from_users')->insert($data);
    }
}