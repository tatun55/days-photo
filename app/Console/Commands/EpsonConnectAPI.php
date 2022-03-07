<?php

namespace App\Console\Commands;

use App\Models\Album;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class EpsonConnectAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:epsonConnectAPI';

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

        $host = 'api.epsonconnect.com'; // You will receive it when the license is issued.
        $accept = 'application/json;charset=utf-8';
        $protocol = '1.1';

        //--------------------------------------------------------------------------------
        // 1. Authentication

        $auth_uri = 'https://' . $host . '/api/1/printing/oauth2/auth/token?subject=printer';
        $client_id = '0de30647289d412e89026b34178e6ec3';
        $secret = 'feVZYfnA9GcDddhMTyn1cJ4c1sEMjK5JMOd4Ns28dtwbIs3nIplCNLlFH6gRcBoX';
        $device = 'qny3834cs9p1q9@print.epsonconnect.com';

        $auth = base64_encode("$client_id:$secret");

        $query_param = array(
            'grant_type' => 'password',
            'username' => $device,
            'password' => ''
        );
        $query_string = http_build_query($query_param, '', '&');

        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Host: ' . $host . "\r\n" .
                    'Accept: ' . $accept . "\r\n" .
                    'Authorization: Basic ' . $auth . "\r\n" .
                    'Content-Length: ' . strlen($query_string) . "\r\n" .
                    'Content-Type: application/x-www-form-urlencoded; charset=utf-8' . "\r\n",
                'content' => $query_string,
                'request_fulluri' => true,
                'protocol_version' => $protocol,
                'ignore_errors' => true
            )
        );

        $http_response_header = null;
        $response = @file_get_contents($auth_uri, false, stream_context_create($options));

        $auth_result = array();
        $auth_result['Response']['Header'] = $http_response_header;
        $auth_result['Response']['Body'] = json_decode($response, true);

        Log::channel('epson')->info('1', [$auth_uri, $query_string, $auth_result]);

        $matches = null;
        preg_match('/HTTP\/1\.[0|1|x] ([0-9]{3})/', $auth_result['Response']['Header'][0], $matches);

        if ($matches[1] !== '200') {
            exit(1);
        }

        //--------------------------------------------------------------------------------
        // 2.0. Get print capavility

        $subject_id = $auth_result['Response']['Body']['subject_id'];
        $access_token = $auth_result['Response']['Body']['access_token'];
        $capavility_uri = 'https://' . $host . '/api/1/printing/printers/' . $subject_id . '/capability/photo';
        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'Host: ' . $host . "\r\n" .
                    'Accept: ' . $accept . "\r\n" .
                    'Authorization: Bearer ' . $access_token . "\r\n" .
                    'Content-Type: application/json;charset=utf-8' . "\r\n",
                'request_fulluri' => true,
                'protocol_version' => $protocol,
                'ignore_errors' => true
            )
        );
        $http_response_header = null;
        $response = @file_get_contents($capavility_uri, false, stream_context_create($options));
        $capavility = json_decode($response, true);

        $isAvailableColor = in_array('color', $capavility["color_modes"], true);
        if (!$isAvailableColor) {
            Log::channel('epson')->error("mono only");
            exit;
        }

        $mediaSizes = array_column($capavility["media_sizes"], 'media_size');
        $indexOfMediaSizeL = array_search('ms_l', $mediaSizes, true);
        if ($indexOfMediaSizeL === false) {
            Log::channel('epson')->error("Media size L is not available");
            exit;
        }
        $mediaTypesOfMediaSizeL = $capavility["media_sizes"][$indexOfMediaSizeL]["media_types"];
        $columnsOfMediaTypesOfMediaSizeL = array_column($mediaTypesOfMediaSizeL, 'media_type');
        $indexOfMediaTypesPhotopaper = array_search('mt_photopaper', $columnsOfMediaTypesOfMediaSizeL, true);
        if ($indexOfMediaTypesPhotopaper === false) {
            Log::channel('epson')->error("Media type photopaper is not available");
            exit;
        }
        $mediaSizeLAndMediaTypePhotopaper = $mediaTypesOfMediaSizeL[$indexOfMediaTypesPhotopaper];

        $quality = in_array('high', $mediaSizeLAndMediaTypePhotopaper["print_qualities"], true)
            ? 'high'
            : 'normal';
        $isBorderless = $mediaSizeLAndMediaTypePhotopaper["borderless"];
        $source = $mediaSizeLAndMediaTypePhotopaper["sources"][0];

        $printSetting = [
            "print_setting" => [
                "media_size" => "ms_l",
                "media_type" => "mt_photopaper",
                "borderless" => $isBorderless,
                "print_quality" => $quality,
                "source" => $source,
                "color_mode" => 'color',
            ]
        ];

        //--------------------------------------------------------------------------------
        // 2. Create print job


        $subject_id = $auth_result['Response']['Body']['subject_id'];
        $access_token = $auth_result['Response']['Body']['access_token'];

        $job_uri = 'https://' . $host . '/api/1/printing/printers/' . $subject_id . '/jobs';

        $data_param = array(
            'job_name' => 'Printing photo job by days',
            'print_mode' => 'photo'
        );

        $data_param = array_merge_recursive($data_param, $printSetting);

        $data = json_encode($data_param);

        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Host: ' . $host . "\r\n" .
                    'Accept: ' . $accept . "\r\n" .
                    'Authorization: Bearer ' . $access_token . "\r\n" .
                    'Content-Length: ' . strlen($data) . "\r\n" .
                    'Content-Type: application/json;charset=utf-8' . "\r\n",
                'content' => $data,
                'request_fulluri' => true,
                'protocol_version' => $protocol,
                'ignore_errors' => true
            )
        );

        $http_response_header = null;
        $response = @file_get_contents($job_uri, false, stream_context_create($options));

        $job_result = array();
        $job_result['Response']['Header'] = $http_response_header;
        $job_result['Response']['Body'] = json_decode($response, true);

        Log::channel('epson')->info('2', [$job_uri, $data, $job_result]);

        $matches = null;
        preg_match('/HTTP\/1\.[0|1|x] ([0-9]{3})/', $job_result['Response']['Header'][0], $matches);

        if ($matches[1] !== '201') {
            exit(1);
        }

        //--------------------------------------------------------------------------------
        // 3. Upload print file

        $job_id = $job_result['Response']['Body']['id'];
        $base_uri = $job_result['Response']['Body']['upload_uri'];


        $ids = Album::orderBy('created_at', 'desc')->first()->photos()->pluck('id');
        $file_paths = [];
        foreach ($ids as $key => $value) {
            $file_paths[] = \Storage::disk('s3')->url("o/{$value}.jpg");
        }

        foreach ($file_paths as $key => $file_path) {

            $content_type = 'application/octet-stream';

            $key++;
            $file_name = "{$key}.jpg";
            $upload_uri = $base_uri . '&File=' . $file_name;

            $data = file_get_contents($file_path);

            $options = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => 'Host: ' . $host . "\r\n" .
                        'Accept: ' . $accept . "\r\n" .
                        'Content-Length: ' . strlen($data) . "\r\n" .
                        'Content-Type: ' . $content_type . "\r\n",
                    'content' => $data,
                    'request_fulluri' => true,
                    'protocol_version' => $protocol,
                    'ignore_errors' => true
                )
            );

            $http_response_header = null;
            $response = @file_get_contents($upload_uri, false, stream_context_create($options));

            $upload_result = array();
            $upload_result['Response']['Header'] = $http_response_header;
            $upload_result['Response']['Body'] = json_decode($response, true);

            Log::channel('epson')->info('3', [$upload_uri, $upload_result]);

            $matches = null;
            preg_match('/HTTP\/1\.[0|1|x] ([0-9]{3})/', $upload_result['Response']['Header'][0], $matches);

            if ($matches[1] !== '200') {
                exit(1);
            }
        }

        //--------------------------------------------------------------------------------
        // 4. Execute print

        $print_uri = 'https://' . $host . '/api/1/printing/printers/' . $subject_id . '/jobs/' . $job_id . '/print';

        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Host: ' . $host . "\r\n" .
                    'Accept: ' . $accept . "\r\n" .
                    'Authorization: Bearer ' . $access_token . "\r\n",
                'request_fulluri' => true,
                'protocol_version' => $protocol,
                'ignore_errors' => true
            )
        );

        $http_response_header = null;
        $response = @file_get_contents($print_uri, false, stream_context_create($options));

        $print_result = array();
        $print_result['Response']['Header'] = $http_response_header;
        $print_result['Response']['Body'] = json_decode($response, true);

        Log::channel('epson')->info('4', [$print_uri, $print_result]);
    }
}
