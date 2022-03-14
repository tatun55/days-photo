@extends('layouts.app')

@section('content')
<main>
    <div class="section">
        <div class="container">
            <div class="row justify-content-lg-center pt-4 pt-md-0">

                <!--Breadcrumb-->
                <nav class="ms-2 mb-0 mt-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-transparent">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fas fa-home"></span></span> ホーム</a></li>
                        <li class="breadcrumb-item active" aria-current="page">カート</li>
                    </ol>
                </nav>
                <!--End of Breadcrumb-->

                @if($cartItems->isEmpty())
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
                    <h5 class="my-4 text-center">カート内の商品</h5>
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

@if(!$cartItems->isEmpty())
    <script src="https://static-fe.payments-amazon.com/checkout.js"></script>
    <script type="text/javascript" charset="utf-8">
        amazon.Pay.renderButton('#AmazonPayButton', {
            // set checkout environment
            merchantId: 'A1V2ZW022WI0BY',
            ledgerCurrency: 'JPY',
            // sandbox: true,
            // customize the buyer experience
            checkoutLanguage: 'ja_JP',
            productType: 'PayAndShip',
            placement: 'Cart',
            buttonColor: 'DarkGray', // Gold,DarkGray,LightGray
            // configure Create Checkout Session request
            createCheckoutSessionConfig: {
                payloadJSON: '{"scopes": ["name", "email", "phoneNumber", "billingAddress"],"storeId":"amzn1.application-oa2-client.9f751aa7eed74bcaab087e055526b188","webCheckoutDetails":{"checkoutReviewReturnUrl":"https://days.photo/order/review"}}', // string generated in step 2
                signature: 'QdBE/SNvg0+Tb/kKq5eDQyN/do6om1XSNhcLo0n60hUqBxsr25e2BvqiCbOrWZvUdjRBC09XwOSj+f3tV3mHKVsaMJeHqLrbLf7p6Ymahz01CtrXPd4blz0uyo7B3dfb2Ymt4AvqflPD+FGXmSdFf2xcp06fprryXYUXo8C0JhcjhM4k22MiyhFRvLWxzRDExyBsixGL4zJNcwy1Py2ZkAd+SmLSbrQJwbyL1B4j7nc6QRIWfVK8stlBBrHCm1oL0LFVYH2hx1L1ZM/gcFDAWVXgGYY93seNABkRE4cxa3edWeWR+wWItL/Og6jHh7KRfp2IC9FtBkIn73R4QiyKYw==', // signature generated in step 3
                publicKeyId: 'LIVE-AH43ZKTFUKLSJ5GEU2VKUWE5'
            }
        });

    </script>
@endif

@endsection
