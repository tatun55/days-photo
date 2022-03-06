@extends('layouts.app')

@section('content')
<main>
    <div class="section">
        <div class="container">
            <div class="row pt-4 pt-md-0">
                <h5 class="my-4 text-center">ご注文手続き</h5>
                <div class="col-md-8">
                    <div class="card mb-4" id="highlight1">

                        <div class="card-body">

                            <h5>お届け先</h5>

                            <table id="table-address" class="table">
                                <tbody>
                                    <tr>
                                        <th>お名前:</th>
                                        <td id="addressName">
                                            {{ $response->shippingAddress->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>郵便番号:</th>
                                        <td>
                                            <div id="addressZipcode">
                                                {{ substr_replace($response->shippingAddress->postalCode, '-', 3, 0) }}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>住所:</th>
                                        <td>
                                            <div id="addressStageOfRegion">
                                                {{ $response->shippingAddress->stateOrRegion }}
                                            </div>
                                            <div id="addressLine1">
                                                {{ $response->shippingAddress->addressLine1 }}
                                            </div>
                                            <div id="addressLine2">
                                                {{ $response->shippingAddress->addressLine2 }}
                                            </div>
                                            <div id="addressLine3">
                                                {{ $response->shippingAddress->addressLine3 }}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>電話番号:</th>
                                        <td>
                                            <div id="phoneNumber">
                                                {{ $response->shippingAddress->phoneNumber }}
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button id="change-address-btn" class="btn btn-gray-200 float-end" type="button">お届け先修正</button>
                        </div>
                    </div>



                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 for="paymentDescriptor">お支払い方法</h5>
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3" style="width: 30px;">
                                    <img class="w-100" src="{{ asset('img/logo-pay.png') }}">
                                </div>
                                <div id="paymentDescriptor" class="form-control-plaintext">{{ $response->paymentPreferences[0]->paymentDescriptor }}</div>
                            </div>

                            <a class="btn btn-outline-gray-600 mb-4" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                ▼ ご請求先情報
                            </a>
                            <div class="collapse mb-4" id="collapseExample">
                                <form>
                                    <div class="row">
                                        <div class="form-group mb-3 col-sm-6">
                                            <label for="inputCity">お名前</label>
                                            <div class="form-control-plaintext" id="addressName02">
                                                {{ $response->billingAddress->name }}
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 col-sm-6">
                                            <label for="mail">メールアドレス</label>
                                            <div class="form-control-plaintext" id="buyerEmail">
                                                {{ $response->buyer->email }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-3 col-sm-6">
                                            <label for="inputZip">郵便番号</label>
                                            <div class="form-control-plaintext" id="ba-addressZipcode">
                                                {{ $response->billingAddress->postalCode }}
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 col-sm-6">
                                            <label for="inputState">電話番号</label>
                                            <div class="form-control-plaintext" id="ba-phoneNumber">
                                                {{ $response->billingAddress->phoneNumber }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                            <label for="inputZip">住所</label>
                                            <div class="form-control-plaintext" id="ba-stateOrRegion">
                                                <span class="me-3">{{ $response->billingAddress->stateOrRegion }}</span><span class="me-3">{{ $response->billingAddress->addressLine1 }}</span><span class="me-3">{{ $response->billingAddress->addressLine2 }}</span><span class="me-3">{{ $response->billingAddress->addressLine3 }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <form class="mb-4">
                                <button id="change-payment-btn" class="btn btn-gray-200 float-end" type="button">お支払い方法修正</button>
                            </form>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">ご注文内容</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col"> </th>
                                        <th scope="col">商品名</th>
                                        <th scope="col">単価(税込)</th>
                                        <th scope="col" class="text-center">数量</th>
                                        <th scope="col" class="text-right">小計</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><img class="confirmation-item" src="./02_files/sample1.jpg"></td>
                                        <td>コロンビア・ビルバオ コーヒー豆</td>
                                        <td class="text-right">￥2,000</td>
                                        <td class="text-right">1</td>
                                        <td class="text-right">￥2,000</td>
                                    </tr>
                                    <tr>
                                        <td><img class="confirmation-item" src="./02_files/sample2.jpg"></td>
                                        <td>コーヒーカップ</td>
                                        <td class="text-right">￥500</td>
                                        <td class="text-right">1</td>
                                        <td class="text-right">￥500</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <!-- Sidebar Widgets Column -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <form method="post" action="{{ route('amazon-pay.checkout') }}">
                            @csrf
                            <input type="hidden" name="checkout_session_id" value="{{ $response->checkoutSessionId }}">
                            <div class="card-body" id="highlight2">
                                <h5>お支払い金額</h5>

                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>商品合計</td>
                                            <td class="text-right">￥2,500</td>
                                        </tr>
                                        <tr>
                                            <td>送料</td>
                                            <td class="text-right">￥500</td>
                                        </tr>
                                        <tr>
                                            <td><strong>総合計</strong></td>
                                            <td class="text-right"><strong>￥3,000</strong></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div>
                                    <button id="placeorder" class="btn btn-primary" type="submit">購入する</button>
                                </div>

                                <div class="mt-3">
                                    <p>※デモサイトです</p>
                                    <p class="mb-0">※会員登録・課金はされません</p>
                                </div>

                            </div>
                        </form>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">配送方法</h5>
                            <p>指定なし</p>
                            <button class="btn btn-gray-200 float-end">変更</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</main>
@endsection

@section('script')
<script src="https://static-na.payments-amazon.com/checkout.js"></script>
<script type="text/javascript" charset="utf-8">
    amazon.Pay.bindChangeAction('#change-address-btn', {
        amazonCheckoutSessionId: '{{ $response->checkoutSessionId }}',
        changeAction: 'changeAddress'
    });
    amazon.Pay.bindChangeAction('#change-payment-btn', {
        amazonCheckoutSessionId: '{{ $response->checkoutSessionId }}',
        changeAction: 'changePayment'
    });

</script>
@endsection
