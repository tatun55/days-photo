<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class GenerateThumbnail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:GenerateThumbnail';

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
        // $itemId = '15632008989699';
        // $httpClient = new CurlHTTPClient(config('services.line.messaging_api.access_token'));
        // $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.messaging_api.channel_secret')]);
        // $response = $bot->getMessageContent($itemId);
        // $img = \Image::make($response->getRawBody());
        // dump($img->exif());
        // $img
        //     ->resize(320, 320, function ($constraint) {
        //         $constraint->aspectRatio();
        //         $constraint->upsize();
        //     })
        //     ->encode()
        //     ->save(storage_path($itemId . '.jpg'));
        // $img = \Image::make(storage_path('15632008989699.jpg'));
        // dump($img->exif());
        $itemId = '15632008989699';
        $httpClient = new CurlHTTPClient(config('services.line.messaging_api.access_token'));
        $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.messaging_api.channel_secret')]);
        $response = $bot->getMessageContent($itemId);
        $img = \Image::make($response->getRawBody());
        $tStrm = $img
            ->resize(320, 320, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->stream('jpg', '20');
        // $img = \Image::make(storage_path('15632008989699.jpg'));
        // dump($img->exif());
        Storage::disk('s3')->put('/t/' . $itemId . '.jpg', $tStrm, 'public');
        dump($url = Storage::disk('s3')->url('/t/' . $itemId . '.jpg'));
        dump(\Image::make($url)->exif());
    }
}