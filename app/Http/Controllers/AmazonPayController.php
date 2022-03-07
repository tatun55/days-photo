<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AmazonPayController extends Controller
{
    public function review(Request $request)
    {
        $amazonpay_config = array(
            'public_key_id' => config('services.amazon_pay.public_key_id'),
            'private_key'   => storage_path('AmazonPay_SANDBOX-AGD5WXBVODNZLYLNPJJEQBUU.pem'),
            'region'        => 'JP',
            'sandbox'       => true
        );

        try {
            $client = new \Amazon\Pay\API\Client($amazonpay_config);
            $checkoutSessionId = $request->amazonCheckoutSessionId;
            $result = $client->getCheckoutSession($checkoutSessionId);
            if ($result['status'] === 200) {
                // $response = json_decode($result['response'], true);
                $response = json_decode($result['response'], false); // object
                // dd($response->chargeId);

                return view('pages.user.payment-review', compact('response'));

                // NOTE: Once Checkout Session moves to a "Completed" state, buyer and shipping
                // details must be obtained from the getCharges() function call instead

                $checkoutSessionState = $response['statusDetails']['state'];
                $chargeId = $response['chargeId'];
                $chargePermissionId = $response['chargePermissionId'];

                $buyerName = $response['buyer']['name'];
                $buyerEmail = $response['buyer']['email'];

                $shipName = $response['shippingAddress']['name'];
                $shipAddrLine1 = $response['shippingAddress']['addressLine1'];
                $shipCity = $response['shippingAddress']['city'];
                $shipState = $response['shippingAddress']['stateOrRegion'];
                $shipZip = $response['shippingAddress']['postalCode'];
                $shipCounty = $response['shippingAddress']['countryCode'];

                echo "checkoutSessionState=$checkoutSessionState\n";
                echo "chargeId=$chargeId; chargePermissionId=$chargePermissionId\n";
                echo "buyer=$buyerName ($buyerEmail)\n";
                echo "shipName=$shipName\n";
                echo "address=$shipAddrLine1; $shipCity $shipState $shipZip ($shipCounty)\n";
            } else {
                // check the error
                echo 'status=' . $result['status'] . '; response=' . $result['response'] . "\n";
            }
        } catch (\Exception $e) {
            // handle the exception
            echo $e . "\n";
        }
        return;
    }

    public function checkout(Request $request)
    {
        // dd($request);
        $amazonpay_config = array(
            'public_key_id' => config('services.amazon_pay.public_key_id'),
            'private_key'   => storage_path('AmazonPay_SANDBOX-AGD5WXBVODNZLYLNPJJEQBUU.pem'),
            'region'        => 'JP',
            'sandbox'       => true
        );

        $payload = array(
            'webCheckoutDetails' => array(
                'checkoutResultReturnUrl' => 'https://days.photo/amazon-pay/complete',
            ),
            'paymentDetails' => array(
                'paymentIntent' => 'Authorize',
                'canHandlePendingAuthorization' => false,
                'chargeAmount' => array(
                    'amount' => '1',
                    'currencyCode' => 'JPY'
                ),
            ),
            'merchantMetadata' => array(
                'merchantReferenceId' => \Str::uuid(),
                'merchantStoreName' => 'daysフォト',
                'noteToBuyer' => 'ご注文ありがとうございます。'
            )
        );

        try {
            $checkoutSessionId = $request->checkout_session_id;
            $client = new \Amazon\Pay\API\Client($amazonpay_config);
            $result = $client->updateCheckoutSession($checkoutSessionId, $payload);
            if ($result['status'] === 200) {
                $response = json_decode($result['response'], true);
                $amazonPayRedirectUrl = $response['webCheckoutDetails']['amazonPayRedirectUrl'];
                return redirect()->away($amazonPayRedirectUrl);
            } else {
                // check the error
                echo 'status=' . $result['status'] . '; response=' . $result['response'] . "\n";
            }
        } catch (\Exception $e) {
            // handle the exception
            echo $e . "\n";
        }
    }

    public function complete(Request $request)
    {
        // dd($request);
        $amazonpay_config = array(
            'public_key_id' => config('services.amazon_pay.public_key_id'),
            'private_key'   => storage_path('AmazonPay_SANDBOX-AGD5WXBVODNZLYLNPJJEQBUU.pem'),
            'region'        => 'JP',
            'sandbox'       => true
        );

        $payload = array(
            'chargeAmount' => array(
                'amount' => '1',
                'currencyCode' => 'JPY'
            ),
        );

        try {
            $checkoutSessionId = $request->amazonCheckoutSessionId;

            $client = new \Amazon\Pay\API\Client($amazonpay_config);
            $result = $client->completeCheckoutSession($checkoutSessionId, $payload);

            if ($result['status'] === 200) {
                $response = json_decode($result['response'], true);

                dd($response);

                echo "state=$state; reasonCode=$reasonCode; reasonDescription=$reasonDescription\n";
            } else {
                // check the error
                echo 'status=' . $result['status'] . '; response=' . $result['response'] . "\n";
            }
        } catch (\Exception $e) {
            // handle the exception
            echo $e . "\n";
        }
    }
}