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
        $count = ImageFromUser::where('album_id', 'a7190e6d-d09f-49ca-b716-9c0ffb159ac8')->count();
        $array = [];
        for ($i = 1; $i <= $count; $i++) {
            $array[] = ['index' => $i];
        }
        ImageFromUser::where('album_id', 'a7190e6d-d09f-49ca-b716-9c0ffb159ac8')->orderBy('index', 'asc')->updateBulk($array);
        // dump(range(1, ImageFromUser::where('album_id', 'a7190e6d-d09f-49ca-b716-9c0ffb159ac8')->count()));
        // dump(ImageFromUser::where('album_id', 'a7190e6d-d09f-49ca-b716-9c0ffb159ac8')->count());
        dump(ImageFromUser::where('album_id', 'a7190e6d-d09f-49ca-b716-9c0ffb159ac8')->orderBy('index', 'asc')->pluck('index'));
    }
}