<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AmazonPayController extends Controller
{
    public function review(Request $request)
    {
        /**
         * 
         * example
         *
         */

        $amazonpay_config = array(
            'public_key_id' => config('services.amazon_pay.public_key_id'),
            'private_key'   => storage_path('AmazonPay_SANDBOX-AGD5WXBVODNZLYLNPJJEQBUU.pem'),
            'region'        => 'JP',
            'sandbox'       => true
        );

        try {
            $checkoutSessionId = $request->amazonCheckoutSessionId;
            $client = new \Amazon\Pay\API\Client($amazonpay_config);
            $result = $client->getCheckoutSession($checkoutSessionId);
            if ($result['status'] === 200) {
                $response = json_decode($result['response'], true);
                $checkoutSessionState = $response['statusDetails']['state'];
                $chargeId = $response['chargeId'];
                $chargePermissionId = $response['chargePermissionId'];

                // NOTE: Once Checkout Session moves to a "Completed" state, buyer and shipping
                // details must be obtained from the getCharges() function call instead
                $buyerName = $response['buyer']['name'];
                $buyerEmail = $response['buyer']['email'];
                $shipName = $response['shippingAddress']['name'];
                $shipAddrLine1 = $response['shippingAddress']['addressLine1'];
                $shipCity = $response['shippingAddress']['city'];
                $shipState = $response['shippingAddress']['stateOrRegion'];
                $shipZip = $response['shippingAddress']['postalCode'];
                $shipCounty = $response['shippingAddress']['countryCode'];

                return view('pages.user.payment-review', compact('response'));



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
}
