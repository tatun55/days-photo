@extends('layouts.app')

@section('content')
<main>
    <div class="section">
        <div class="container">
            <div class="row">

                <!--Breadcrumb-->
                <nav class="ms-2 mb-0 mt-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-transparent">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fas fa-home me-1"></span></span>ホーム</a></li>
                        <li class="breadcrumb-item active" aria-current="page">アカウントサービス</li>
                    </ol>
                </nav>
                <!--End of Breadcrumb-->

                @include('sections.profile-card')

                <div class="col-12 col-lg-8 mt-4 mt-lg-3">

                    <nav>
                        <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active"><span class="fas fa-images me-1"></span>購入履歴</a>
                            {{-- <a class="nav-item nav-link"><span class="fas fa-images me-1"></span>お届け先</a> --}}
                        </div>
                    </nav>

                    @if($orders->isEmpty())
                        <div class="card p-1 p-md-4 mb-4 mb-lg-0 bg-gray-100">
                            <div class="card-body">
                                <div class="icon icon-shape icon-shape-primary rounded-circle mb-4">
                                    <span class="far fa-lightbulb"></span>
                                </div>
                                <h3 class="h5 mb-3">現在、商品を購入された履歴がありません。</h3>
                                <p><code class="px-2 py-1 mx-2 d-inline-block bg-gray-300">アルバムのドロップダウンメニュー</code><span><i class="fa fa-arrow-right"></i></span><code class="px-2 py-1 mx-2 d-inline-block bg-gray-300">ミニアルバムを作る</code> で、部屋にかざれるミニアルバムを作れます。</p>
                            </div>
                        </div>
                    @else
                        @foreach($orders as $order)
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">ご注文内容</h5>
                                    <small class="d-block">オーダーID : {{ $order->id }}</small>
                                    <small class="d-block">注文日時 : {{ $order->created_at->toDateTimeString() }}</small>
                                    <small class="d-block">お支払い金額 : ￥{{ number_format( $order->total_price ) }}</small>
                                    <small class="d-block">ステータス :
                                        @switch($order->status)
                                            @case('confirmed')
                                                発送前
                                                @break
                                            @case('shipping')
                                                輸送中（発送済）
                                                @break
                                            @case('shipped')
                                                到着済
                                                @break
                                            @case('canceled')
                                                キャンセル済み
                                                @break
                                            @default

                                        @endswitch
                                    </small>
                                    <div id="cart-table-wrapper">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th> </th>
                                                    <th>タイトル</th>
                                                    <th style="width: 16%">タイプ</th>
                                                    <th style="width: 16%">印刷</th>
                                                    <th style="width: 8%">数量</th>
                                                    <th style="width: 8%">価格</th>
                                                    <th style="width: 8%">小計</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->cartItems()->get() as $cartItem)
                                                    <tr class="text-center">
                                                        <th aria-label="お写真">
                                                            <div class="mx-auto m-3 my-md-0" style="width: 80px; height: 80px;">
                                                                <img class="rounded" src="{{ $cartItem->album->cover }}" alt="...">
                                                            </div>
                                                        </th>
                                                        <td aria-label="タイトル">{{ $cartItem->album->title }}</td>
                                                        <td aria-label="タイプ">
                                                            シンプル
                                                        </td>
                                                        <td aria-label="印刷">
                                                            @if($cartItem->self_print)
                                                                セルフ
                                                            @else
                                                                弊社
                                                            @endif
                                                        </td>
                                                        <td aria-label="価格">
                                                            ￥1
                                                        </td>
                                                        <td aria-label="数量">
                                                            1
                                                        </td>
                                                        <td aria-label="小計">
                                                            ￥1
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>

            </div>
        </div>
    </div>


</main>
@endsection
