<?php

namespace App\Console\Commands;

use App\Models\Photo;
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



        $arr = Photo::where('album_id', '9e5e6590-8aa9-416f-a447-ed244d759565')->orderBy('index', 'asc')->get()->toArray();
        // $arr = Photo::orderBy('index', 'asc')->get()->toArray();
        // dd($arr);
        $newArr = [];
        $now = \Carbon\Carbon::now();
        foreach ($arr as $key => $value) {
            $merged = array_merge($value, ['index' => $key + 1, 'created_at' => \Carbon\Carbon::create($value["created_at"])->toDateTimeString(), 'updated_at' => $now]);
            $newArr[] = $merged;
        }
        dd($newArr);
        DB::table('image_from_users')->upsert($newArr, ['id'], ['index']);
        // Photo::upsert($newArr, 'id', ['index']);
        // $res = Photo::where('album_id', 'a7190e6d-d09f-49ca-b716-9c0ffb159ac8')->orderBy('index', 'asc')->get(['id', 'index'])->toArray();
        // dd($res);
    }
}
