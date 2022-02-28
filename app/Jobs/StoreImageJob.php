<?php

namespace App\Jobs;

use App\Models\Album;
use App\Models\ImageFromUser;
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

            // pngならjpgに変換
            $image = \Image::make($stream);
            switch ($response->getHeader('content-type')) {
                case 'image/png':
                    $stream = $image->stream('jpg', 95);
                    break;
            };

            // オリジナルをアップロード
            Storage::disk('s3')->put("/o/{$path}", $stream, 'public');

            // width,heightを保存
            $imageFromUser = ImageFromUser::find($this->imageId);
            $imageFromUser->width = $image->width();
            $imageFromUser->height = $image->height();
            $imageFromUser->save();

            // upload thumbnail (Small,Medium,Large)
            $sizes = [
                's' => 320,
                'm' => 960,
                'l' => 1600,
            ];
            $image->backup();
            foreach ($sizes as $key => $value) {
                $stream = $image
                    ->resize($value, $value, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->stream('jpg', '70');
                Storage::disk('s3')->put("/{$key}/{$path}", $stream, 'public');
                $image->reset();
            }
        } else {
            Log::error($response->getHTTPStatus() . ' ' . $response->getRawBody());
        }
    }
}