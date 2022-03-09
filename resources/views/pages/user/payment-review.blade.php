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

                    @include('sections.cart.item-info',['isReview'=> true])


                </div>

                <!-- Sidebar Widgets Column -->
                <div class="col-md-4">
                    @include('sections.cart.total-price',['isReview'=> true])
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
