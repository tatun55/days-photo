<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Services\EpsonConnectApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartItemController extends Controller
{
    public function store(Request $request)
    {
        $cartItem = new CartItem();
        $cartItem->id = \Str::uuid();
        $cartItem->user_id = $request->user_id;
        $cartItem->album_id = $request->album_id;
        $cartItem->type = $request->type;
        $cartItem->self_print = $request->self_print;
        $cartItem->save();

        // cart_item_photoをsync
        $cartItemPhotoIds = $cartItem->album->photos()->whereHas('users', function ($q) {
            $q->where('user_id', Auth::user()->id)->where('is_archived', false);
        })
            ->orderBy('created_at')
            ->pluck('id');
        $cartItem->photos()->sync($cartItemPhotoIds);

        return redirect('cart')->with('status', 'カートに追加されました');
    }

    public function cart()
    {
        $cartItems = CartItem::where('user_id', Auth::user()->id)->where('order_id', null)->orderBy('created_at', 'desc')->get();
        $price = 0;
        foreach ($cartItems as $cartItem) {
            $price += 1;
        }
        $total = [
            'price' => $price,
            'postage' => 0,
            'total_price' => $price,
        ];
        $total = json_decode(json_encode($total), false);
        return view('pages.user.cart', compact('cartItems', 'total'));
    }

    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();
        return redirect('cart')->with('status', 'カート内の商品が削除されました');
    }

    public function review(Request $request)
    {
        $amazonpay_config = array(
            'public_key_id' => config('services.amazon_pay.public_key_id'),
            'private_key'   => storage_path('AmazonPay_LIVE-AH43ZKTFUKLSJ5GEU2VKUWE5.pem'),
            'region'        => 'JP',
        );

        try {
            $client = new \Amazon\Pay\API\Client($amazonpay_config);
            $checkoutSessionId = $request->amazonCheckoutSessionId;
            $result = $client->getCheckoutSession($checkoutSessionId);
            if ($result['status'] === 200) {
                $response = json_decode($result['response'], false); // object

                // price info
                $cartItems = CartItem::where('user_id', Auth::user()->id)->where('order_id', null)->orderBy('created_at', 'desc')->get();
                $total = $this->getCurrentCartTotal($cartItems);

                return view('pages.user.payment-review', compact('response', 'cartItems', 'total'));
            } else {
                \Log::emergency('status=' . $result['status'] . '; response=' . $result['response'] . "\n");
                return redirect('cart')->with('status', '決済中にエラーが発生しました');
            }
        } catch (\Exception $e) {
            \Log::emergency('order error : ' . $e . "\n");
            return redirect('cart')->with('status', '決済中にエラーが発生しました');
        }
        return;
    }

    private function getCurrentCartTotal($cartItems)
    {
        $price = 0;
        foreach ($cartItems as $cartItem) {
            $price += 1;
        }
        $total = [
            'price' => $price,
            'postage' => 0,
            'total_price' => $price,
        ];
        return json_decode(json_encode($total), false);
    }

    public function checkout(Request $request)
    {
        $cartItems = CartItem::where('user_id', Auth::user()->id)->where('order_id', null)->orderBy('created_at', 'desc')->get();
        $total = $this->getCurrentCartTotal($cartItems);

        $amazonpay_config = array(
            'public_key_id' => config('services.amazon_pay.public_key_id'),
            'private_key'   => storage_path('AmazonPay_LIVE-AH43ZKTFUKLSJ5GEU2VKUWE5.pem'),
            'region'        => 'JP',
        );

        $payload = array(
            'webCheckoutDetails' => array(
                'checkoutResultReturnUrl' => 'https://days.photo/order/complete',
            ),
            'paymentDetails' => array(
                'paymentIntent' => 'Authorize',
                'canHandlePendingAuthorization' => false,
                'chargeAmount' => array(
                    'amount' => $total->total_price,
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
                \Log::emergency('status=' . $result['status'] . '; response=' . $result['response'] . "\n");
                return redirect('cart')->with('status', '決済中にエラーが発生しました');
            }
        } catch (\Exception $e) {
            \Log::emergency('order error : ' . $e . "\n");
            return redirect('cart')->with('status', '決済中にエラーが発生しました');
        }
    }

    public function complete(Request $request)
    {
        $cartItems = CartItem::where('user_id', Auth::user()->id)->where('order_id', null)->orderBy('created_at', 'desc')->get();
        $total = $this->getCurrentCartTotal($cartItems);

        $amazonpay_config = array(
            'public_key_id' => config('services.amazon_pay.public_key_id'),
            'private_key'   => storage_path('AmazonPay_LIVE-AH43ZKTFUKLSJ5GEU2VKUWE5.pem'),
            'region'        => 'JP',
        );

        $payload = array(
            'chargeAmount' => array(
                'amount' => $total->total_price,
                'currencyCode' => 'JPY'
            ),
        );

        try {
            $checkoutSessionId = $request->amazonCheckoutSessionId;

            $client = new \Amazon\Pay\API\Client($amazonpay_config);
            $result = $client->completeCheckoutSession($checkoutSessionId, $payload);

            if ($result['status'] === 200) {
                $response = json_decode($result['response'], true);

                if ($response['statusDetails']['state'] === 'Completed') {
                    try {
                        DB::beginTransaction();

                        $order = new Order();
                        $order->id = \Str::uuid();
                        $order->user_id = Auth::user()->id;
                        $order->total_price = $total->total_price;
                        $order->raw_resp = $result['response'];
                        $order->save();

                        // add order_id to cart items witch ordered
                        $arr = $cartItems->toArray();
                        $newArr = [];
                        $now = \Carbon\Carbon::now();
                        foreach ($arr as $key => $value) {
                            $merged = array_merge($value, ['order_id' => $order->id, 'created_at' => \Carbon\Carbon::create($value["created_at"])->toDateTimeString(), 'updated_at' => $now->toDateTimeString()]);
                            $newArr[] = $merged;
                        }
                        CartItem::upsert($newArr, 'id', ['order_id']);

                        DB::commit();
                        return redirect('account')->with('order_completed', 'ご注文が完了しました');
                    } catch (Throwable $e) {
                        DB::rollBack();
                        \Log::emergency(json_encode($e, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                        return redirect('cart')->with('status', '決済中にエラーが発生しました');
                    }
                } else {
                    \Log::emergency('status=' . $result['status'] . '; response=' . $result['response'] . "\n");
                    return redirect('cart')->with('status', '決済中にエラーが発生しました');
                }
            } else {
                \Log::emergency('status=' . $result['status'] . '; response=' . $result['response'] . "\n");
                return redirect('cart')->with('status', '決済中にエラーが発生しました');
            }
        } catch (\Exception $e) {
            \Log::emergency('order error : ' . $e . "\n");
            return redirect('cart')->with('status', '決済中にエラーが発生しました');
        }
    }

    public function print(CartItem $cartItem)
    {
        (new EpsonConnectApiService())->printCartItem($cartItem);
        return back()->with('status', '印刷ジョブを送信しました');
    }
}