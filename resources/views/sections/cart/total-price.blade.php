<div class="card mb-4">
    <form method="post" action="{{ route('order.checkout') }}">
        @csrf
        @if($isReview)
            <input type="hidden" name="checkout_session_id" value="{{ $response->checkoutSessionId }}">
            <input type="hidden" name="order_id" value="{{ $order->id }}">
        @endif
        <div class="card-body" id="highlight2">
            <h5>お支払い金額</h5>
            <table class="table">
                <tbody>
                    <tr>
                        <td>商品合計</td>
                        <td class="text-right">￥{{ $total->price }}</td>
                    </tr>
                    <tr>
                        <td>送料</td>
                        <td class="text-right">￥0</td>
                    </tr>
                    <tr>
                        <td><strong>総合計</strong></td>
                        <td class="text-right"><strong>￥{{ $total->total_price }}</strong></td>
                    </tr>
                </tbody>
            </table>

            <div>
                {{-- <button id="placeorder" class="btn btn-primary" type="submit">購入する</button> --}}
                @if($isReview)
                    <button id="placeorder" class="btn btn-primary" type="submit">注文を確定</button>
                @else
                    <div id="AmazonPayButton" class="w-100"></div>
                @endif
            </div>

            <div class="mt-3">
                {{-- <p>※デモサイトです</p> --}}
                <p class="mb-0">※課金はされません</p>
            </div>

        </div>
    </form>
</div>
