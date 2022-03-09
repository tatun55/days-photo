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
                            <div class="card-body">
                                <div class="icon icon-shape icon-shape-primary rounded-circle mb-4">
                                    <span class="far fa-lightbulb"></span>
                                </div>
                                <h3 class="h5 mb-3">現在、お届け先がありません</h3>
                                <p>お届け先を登録しておくと、部屋にかざれるミニアルバムをワンクリックで、スムーズに発送できます。</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">ショッピングカート</h5>
                                <div id="cart-table-wrapper">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th> </th>
                                                <th>タイトル</th>
                                                <th style="width: 16%">タイプ</th>
                                                <th style="width: 8%">数量</th>
                                                <th style="width: 8%">価格</th>
                                                <th style="width: 8%">小計</th>
                                                <th style="width: 8%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                                <tr class="text-center">
                                                    <th aria-label="お写真">
                                                        <div class="mx-auto m-3 my-md-0" style="width: 80px; height: 80px;">
                                                            <img class="rounded" src="{{ $order->album->cover }}" alt="...">
                                                        </div>
                                                    </th>
                                                    <td aria-label="タイトル">{{ $order->album->title }}</td>
                                                    <td aria-label="タイプ">
                                                        シンプル
                                                    </td>
                                                    <td aria-label="価格">
                                                        1
                                                    </td>
                                                    <td aria-label="数量">
                                                        1
                                                    </td>
                                                    <td aria-label="小計">
                                                        1
                                                    </td>
                                                    <td aria-label="">
                                                        <div class="d-flex justify-content-center">
                                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Widgets Column -->
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <form method="post" action="{{ route('amazon-pay.checkout') }}">
                                @csrf
                                <input type="hidden" name="checkout_session_id" value="{{}}">
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
                                                <td class="text-right">￥0</td>
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
                                        <p class="mb-0">※課金はされません</p>
                                    </div>

                                </div>
                            </form>
                        </div>

                    </div>
                @endif
            </div>

        </div>

    </div>
</main>
@endsection

@section('script')
@endsection
