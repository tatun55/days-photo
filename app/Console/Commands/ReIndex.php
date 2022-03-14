<?php

namespace App\Console\Commands;

use App\Models\Photo;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ReIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:re-index';

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
        /**
         * Case:Delete 
         * 
         * 1. Make array for updating of targets to delete.
         * 2. Make array for updating of targets not to delete.
         * 3. Merge the arrays.
         * 4. Upsert with the arrays.
         */

        $indexesToDelete = [1, 2, 3];

        $arrayToDelete = [];
        $arrayNotToDelete = [];

        $countNotToDelete = 0;
        $countToDelete = 0;
        $count = 0;

        $now = Carbon::now()->toDateTimeString();

        // Generate $arrayToDelete
        $count = Photo::where('album_id', 'a405a965-5eeb-4af4-9816-f1a9e371829f')->onlyTrashed()->count();
        $imagesToDelete = Photo::where('album_id', 'a405a965-5eeb-4af4-9816-f1a9e371829f')->orderBy('index', 'asc')->whereIn('index', $indexesToDelete)->get()->toArray();
        foreach ($imagesToDelete as $key => $value) {
            $merged = array_merge($value, [
                'index' => $key + 1 + $count,
                'deleted_at' => $now,
                'created_at' => Carbon::create($value["created_at"])->toDateTimeString(),
                'updated_at' => Carbon::create($value["updated_at"])->toDateTimeString(),
            ]);
            $arrayToDelete[] = $merged;
        }
        // dd($arrayToDelete);

        $imagesNotToDelete = Photo::where('album_id', 'a405a965-5eeb-4af4-9816-f1a9e371829f')->orderBy('index', 'asc')->whereNotIn('index', $indexesToDelete)->get()->toArray();
        foreach ($imagesNotToDelete as $key => $value) {
            $merged = array_merge($value, [
                'index' => $key + 1,
                'deleted_at' => null,
                'created_at' => Carbon::create($value["created_at"])->toDateTimeString(),
                'updated_at' => Carbon::create($value["updated_at"])->toDateTimeString(),
            ]);
            $arrayNotToDelete[] = $merged;
        }
        // dd($arrayNotToDelete);

        $arrayMerged = array_merge($arrayToDelete, $arrayNotToDelete);

        Photo::upsert($arrayMerged, 'id', ['index', 'deleted_at']);
    }
}
