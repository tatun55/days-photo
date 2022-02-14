<?php

namespace App\Jobs;

use App\Models\PostedImage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class StoreLineImageMessageToS3Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $postedImageId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($postedImageId)
    {
        $this->postedImageId = $postedImageId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $postedImage = PostedImage::findOrFail($this->postedImageId);
        $httpClient = new CurlHTTPClient(config('services.line.messaging_api.access_token'));
        $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.messaging_api.channel_secret')]);
        $response = $bot->getMessageContent($postedImage->line_message_id);

        if ($response->isSucceeded()) {
            switch ($response->getHeader('content-type')) {
                case 'image/jpeg':
                    $ext = '.jpg';
                    break;
                case 'image/png':
                    $ext = '.png';
                    break;
            };
            $path = $postedImage->uuid . $ext;
            if (Storage::disk('s3')->put($path, $response->getRawBody(), 'public')) {
                $postedImage->url = Storage::disk('s3')->url($path);
                $postedImage->save();
            };
        } else {
            Log::error($response->getHTTPStatus() . ' ' . $response->getRawBody());
        }
    }
}