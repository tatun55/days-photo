@extends('layouts.app')

@section('content')
<main>
    <div class="section">
        <div class="container">
            <div class="row justify-content-lg-center pt-4 pt-md-0">
                <h5 class="my-4 text-center">カート内の商品</h5>
                @if($orders->isEmpty())
                    <div class="col-lg-8">
                        <div class="card p-1 p-md-4 mb-4 mb-lg-0 bg-gray-100">
                            <div class="card-body text-center">
                                <div class="icon icon-shape icon-shape-primary rounded-circle mb-4">
                                    <span class="far fa-lightbulb"></span>
                                </div>
                                <h3 class="h5 mb-3">現在、カート内に商品がありません</h3>
                                <p><code class="px-2 py-1 mx-2 d-inline-block bg-gray-300">アルバムのドロップダウンメニュー</code><span><i class="fa fa-arrow-right"></i></span><code class="px-2 py-1 mx-2 d-inline-block bg-gray-300">ミニアルバムを作る</code> で商品を追加できます。</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-8">
                        @include('sections.cart.item-info',['isReview'=>false])
                    </div>

                    <!-- Sidebar Widgets Column -->
                    <div class="col-lg-4">
                        @include('sections.cart.total-price',['isReview'=>false])
                    </div>
                @endif
            </div>

        </div>
    </div>
    @include('sections.modals.cart')
</main>
@endsection

@section('script')
<script src="https://static-fe.payments-amazon.com/checkout.js"></script>
<script type="text/javascript" charset="utf-8">
    amazon.Pay.renderButton('#AmazonPayButton', {
        // set checkout environment
        merchantId: 'A1V2ZW022WI0BY',
        ledgerCurrency: 'JPY',
        sandbox: true,
        // customize the buyer experience
        checkoutLanguage: 'ja_JP',
        productType: 'PayAndShip',
        placement: 'Cart',
        buttonColor: 'Gold', // Gold,DarkGray,LightGray
        // configure Create Checkout Session request
        createCheckoutSessionConfig: {
            payloadJSON: '{"scopes": ["name", "email", "phoneNumber", "billingAddress"],"storeId":"amzn1.application-oa2-client.9f751aa7eed74bcaab087e055526b188","webCheckoutDetails":{"checkoutReviewReturnUrl":"https://days.photo/order/review"}}', // string generated in step 2
            signature: '0j3F1awQQ/KwZ4jZTvqgsND9Cs0oAkF44dNPB9DTTssQrZqG9SCgWxr5TjZgyCQqNR1ie/UZGEGah/NWCY/in+0O8vn+cbrV66FZrdgp+fH9ILPlsKsmsOZlPJRtpoZgqPWH2NSE1VRhhCKzbzr4Q1+sjd0PhOsrfrf49WMxjFt4SppKBeqZJmfrUpWCaSv++w0yf9PdfJ+I6VS7mOu8/tLSOWiabQQY2Qyo0edGR+ESr+I1hs6GlXYaoXNHgkDaGHUcZx+tJFIzurpyULkti9vwJDmeoZNhLopmBIWR7Jw/UV64YfsR3KWuC+UzvMl6vAAHAqo8oMcMwCHctN6HiQ==', // signature generated in step 3
            publicKeyId: 'SANDBOX-AGD5WXBVODNZLYLNPJJEQBUU'
        }
    });

</script>
@endsection
