<?php

namespace App\Console\Commands;

use App\Jobs\StoreImageJob;
use App\Models\ImageFromUser;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Jobs\StoreLineImageMessageToS3Job;
use App\Models\ImageSet;
use App\Models\LineUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Throwable;

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
        $imageSetId = '28cfdf2c-c447-45b1-aa46-b953de185b3e';

        // dispatch store image jobs
        $jobs = [];
        $imageFromUsers = ImageFromUser::where('image_set_id', $imageSetId)->get();
        foreach ($imageFromUsers as $imageFromUser) {
            $jobs[] = new StoreImageJob($imageFromUser->id, $imageFromUser->message_id);
        }

        $batch = Bus::batch($jobs)
            ->then(function (Batch $batch) use ($imageSetId) {
                $imageSet = ImageSet::find($imageSetId);
                $imageSet->status = 'stored';
                $imageSet->save();
            })->catch(function (Batch $batch, Throwable $e) {
                Log::error($e->getMessage());
            })->finally(function (Batch $batch) {
            })->dispatch();
    }
}
