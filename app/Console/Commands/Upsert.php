<?php

namespace App\Console\Commands;

use App\Models\ImageFromUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Upsert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:upsert';

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
        // $arr = ImageFromUser::where('album_id', 'a7190e6d-d09f-49ca-b716-9c0ffb159ac8')->orderBy('index', 'asc')->get()->toArray();
        $arr = ImageFromUser::orderBy('index', 'asc')->get()->toArray();
        // dd($arr);
        $newArr = [];
        $now = \Carbon\Carbon::now();
        foreach ($arr as $key => $value) {
            $merged = array_merge($value, ['index' => $key + 1, 'created_at' => $now, 'updated_at' => $now]);
            $newArr[] = $merged;
        }
        // dd($newArr);
        DB::table('image_from_users')->upsert($newArr, ['id'], ['index']);
        // ImageFromUser::upsert($newArr, 'id', ['index']);
        // $res = ImageFromUser::where('album_id', 'a7190e6d-d09f-49ca-b716-9c0ffb159ac8')->orderBy('index', 'asc')->get(['id', 'index'])->toArray();
        // dd($res);
    }
}