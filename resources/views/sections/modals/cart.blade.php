@foreach($orders as $order)
    <div class="modal fade" id="modal-cart-delete-{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-cart-delete-{{ $order->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="POST" action="{{ route('cart.delete',$order->id) }}" class="modal-content">
                @csrf
                @method('delete')
                <div class="modal-header">
                    <h2 class="h6 modal-title">カート内の商品を削除しますか？</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger text-white">削除</button>
                    <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">キャンセル</button>
                </div>
            </form>
        </div>
    </div>
@endforeach
