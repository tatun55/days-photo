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
                                <p><code class="px-2 py-1 me-1 d-inline-block bg-gray-300">アルバムのドロップダウンメニュー</code><span><i class="fa fa-arrow-right"></i></span><code class="px-2 py-1 mx-1 d-inline-block bg-gray-300">ミニアルバムを作る</code> で、部屋にかざれるミニアルバムを作れます。</p>
                            </div>
                        </div>
                    @else
                        @foreach($orders as $order)
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">ご注文 ({{ $order->created_at->toDateTimeString() }}) </h5>
                                    <small class="d-block">オーダーID : {{ $order->id }}</small>
                                    {{-- <small class="d-block">注文日時 : {{ $order->created_at->toDateTimeString() }}</small> --}}
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
                                    <div id="table-responsive-wrapper">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>タイトル</th>
                                                    <th style="width: 12%">タイプ</th>
                                                    <th style="width: 18%">フォト</th>
                                                    <th style="width: 8%">数量</th>
                                                    <th style="width: 8%">価格</th>
                                                    <th style="width: 8%">小計</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->cartItems()->withCount('photos')->get() as $cartItem)
                                                    <tr class="text-center">
                                                        <th class="w-100">
                                                            <div class="img-wrapper-1x1 mx-auto" style="max-width: 100px;">
                                                                <div class="img-content">
                                                                    <img class="rounded" src="{{ $cartItem->album->cover }}" alt="...">
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <td aria-label="タイトル">{{ $cartItem->album->title }}</td>
                                                        <td aria-label="タイプ">
                                                            シンプル
                                                        </td>
                                                        <td aria-label="フォト">
                                                            @if($cartItem->self_print)
                                                                セルフプリント <button class="btn btn-sm btn-primary btn-print" data-bs-toggle="modal" data-bs-target="#modal-print" data-cart-item-id="{{ $cartItem->id }}" data-photos-count="{{ $cartItem->photos_count }}">印刷する</button>
                                                            @else
                                                                アルバムに同梱
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

    <div class="modal fade" id="modal-print" tabindex="-1" role="dialog" aria-labelledby="modal-print" aria-hidden="true">
        <div class="modal-lg modal-dialog modal-dialog-centered" role="document">
            <form id="print-form" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    印刷の準備はよろしいですか？
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="p-0 text-center">
                        <div class="px-4 mb-1">
                            <span class="modal-icon display-1"><i class="fa fa-print"></i></span>
                            <h6 class="h6 modal-title mb-1">設定されたプリンタでフォト印刷を行います</h6>
                            <p class="text-left text-sm-center"><small>写真用紙 L 版サイズを <span id="photos-count"></span> 枚以上セットした状態で行ってください。</small></p>
                        </div>
                        <div id="table-responsive-wrapper" class="p-0">
                            <table>
                                <thead>
                                    <tr>
                                        <th style="width: 36%">プリンタ名</th>
                                        <th style="width: 36%">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td aria-label="プリンタ名"><span style="font-size: 0.8rem">{{ \Auth::user()->printer->name ?? '' }}</span></td>
                                        <td aria-label="Email"><span style="font-size: 0.8rem">{{ \Auth::user()->printer->email ?? '' }}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning text-white" onclick="this.disabled=true;this.value='送信中...'; this.form.submit();">印刷する</button>
                        <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">キャンセル</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
    document.querySelectorAll('.btn-print').forEach(item => {
        item.addEventListener('click', event => {
            var cartItemId = event.currentTarget.getAttribute('data-cart-item-id');
            var actionUrl = `https://days.photo/cart-items/${cartItemId}/print`;
            var printForm = document.getElementById("print-form");
            printForm.action = actionUrl;

            var photosCount = event.currentTarget.getAttribute('data-photos-count');
            document.querySelector('#photos-count').textContent = photosCount;
        });
    });

</script>
@endsection
