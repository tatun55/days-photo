<div class="modal fade" id="modal-title" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="POST" action="{{ route('albums.title',$album->id) }}" class="modal-content">
            @csrf
            @method('put')
            <div class="modal-header">
                <h2 class="h6 modal-title">アルバムのタイトルを入力</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" name="title" value="{{ $album->title }}">
                <div class="form-text text-gray text-right text-sm">50字以内</div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary text-white">変更</button>
                <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">キャンセル</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form method="POST" action="{{ route('albums.archive',$album->id) }}" class="modal-content">
            @csrf
            @method('delete')
            <div class="modal-header">
                <h2 class="h6 modal-title">アーカイブへ移動しますか？</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning text-white">アーカイブへ移動</button>
                <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">キャンセル</button>
            </div>
        </form>
    </div>
</div>

@include('parts.modals.album-order')
