<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrinterRequest;
use App\Models\Printer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PriterController extends Controller
{
    public function store(PrinterRequest $request)
    {
        if (!$this->checkCapavility($request->email)) {
            return back()->with('printer_capavility_error', 'error');
        };

        $printer = new Printer();
        $printer->id = \Str::uuid();
        $printer->user_id = Auth::user()->id;
        $printer->name = $request->name;
        $printer->email = $request->email;
        $printer->save();

        if (Auth::user()->printer_id === null) {
            User::where('id', Auth::user()->id)->update(['printer_id' => $printer->id]);
        }

        return back()->with('status', 'プリンターが登録されました');
    }

    public function available(Request $request)
    {
        Printer::findOrFail($request->printer_id);
        User::where('id', Auth::user()->id)->update(['printer_id' => $request->printer_id]);
        return back()->with('status', '使用中のプリンタが変更されました');
    }

    public function delete(Printer $printer)
    {
        $printer->delete();
        return back()->with('status', 'プリンターが削除されました');
    }

    public function checkCapavility($email)
    {
        $host = 'api.epsonconnect.com'; // You will receive it when the license is issued.
        $accept = 'application/json;charset=utf-8';
        $protocol = '1.1';

        //--------------------------------------------------------------------------------
        // 1. Authentication

        $auth_uri = 'https://' . $host . '/api/1/printing/oauth2/auth/token?subject=printer';
        $client_id = '0de30647289d412e89026b34178e6ec3';
        $secret = 'feVZYfnA9GcDddhMTyn1cJ4c1sEMjK5JMOd4Ns28dtwbIs3nIplCNLlFH6gRcBoX';
        $device = $email;

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
            return false;
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
            return false;
        }

        $mediaSizes = array_column($capavility["media_sizes"], 'media_size');
        $indexOfMediaSizeL = array_search('ms_l', $mediaSizes, true);
        if ($indexOfMediaSizeL === false) {
            Log::channel('epson')->error("Media size L is not available");
            return false;
        }
        $mediaTypesOfMediaSizeL = $capavility["media_sizes"][$indexOfMediaSizeL]["media_types"];
        $columnsOfMediaTypesOfMediaSizeL = array_column($mediaTypesOfMediaSizeL, 'media_type');
        $indexOfMediaTypesPhotopaper = array_search('mt_photopaper', $columnsOfMediaTypesOfMediaSizeL, true);
        if ($indexOfMediaTypesPhotopaper === false) {
            Log::channel('epson')->error("Media type photopaper is not available");
            return false;
        }
        $mediaSizeLAndMediaTypePhotopaper = $mediaTypesOfMediaSizeL[$indexOfMediaTypesPhotopaper];

        if (!in_array('high', $mediaSizeLAndMediaTypePhotopaper["print_qualities"], true)) {
            Log::channel('epson')->error("Quality is only normal");
            return false;
        }
        if (!$mediaSizeLAndMediaTypePhotopaper["borderless"]) {
            Log::channel('epson')->error("Quality is only normal");
            return false;
        };
        return true;
    }
}