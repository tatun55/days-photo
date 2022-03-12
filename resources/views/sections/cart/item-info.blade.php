<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">ショッピングカート</h5>
        <div id="table-responsive-wrapper">
            <table>
                <thead>
                    <tr>
                        <th> </th>
                        <th>タイトル</th>
                        <th style="width: 16%">タイプ</th>
                        <th style="width: 16%">印刷</th>
                        <th style="width: 8%">価格</th>
                        <th style="width: 8%">数量</th>
                        <th style="width: 8%">小計</th>
                        @if(! $isReview)
                            <th style="width: 8%">削除</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $cartItem)
                        <tr class="text-center">
                            <th>
                                <div class="table-img-wrapper mx-auto m-3 my-md-0 rounded">
                                    <img src="{{ $cartItem->album->cover }}" alt="...">
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
                            @if(! $isReview)
                                <td aria-label="削除">
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-cart-delete-{{ $cartItem->id }}"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
