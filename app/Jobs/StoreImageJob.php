<?php

namespace App\Jobs;

use App\Models\Album;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class StoreImageJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $imageId;
    protected $messageId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($imageId, $messageId)
    {
        $this->imageId = $imageId;
        $this->messageId = $messageId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $httpClient = new CurlHTTPClient(config('services.line.messaging_api.access_token'));
        $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.messaging_api.channel_secret')]);
        $response = $bot->getMessageContent($this->messageId);
        if ($response->isSucceeded()) {
            $path = $this->imageId . '.jpg';
            $stream = $response->getRawBody();
            switch ($response->getHeader('content-type')) {
                case 'image/png':
                    $stream = \Image::make($stream)->stream('jpg');
                    break;
            };
            Storage::disk('s3')->put($path, $stream, 'public');

            // upload thumbnail
            $tStream = \Image::make($stream)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->stream('jpg', '30');
            Storage::disk('s3')->put("/t/{$path}", $tStream, 'public');
        } else {
            Log::error($response->getHTTPStatus() . ' ' . $response->getRawBody());
        }
    }
}