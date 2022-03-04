<div class="modal fade" id="modal-restore-{{ $album->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form id="form-restore-{{ $album->id }}" method="POST" action="{{ route('albums.restore',$album->id) }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h2 class="h6 modal-title">このアルバムを元に戻しますか？</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary text-white">アルバムを元に戻す</button>
                <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">キャンセル</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal-force-delete-{{ $album->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form id="form-force-delete-{{ $album->id }}" method="POST" action="{{ route('albums.delete.force',$album->id) }}" class="modal-content">
            @csrf
            @method('delete')
            <div class="modal-header">
                <h2 class="h6 modal-title">データを完全に削除しますか？</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger text-white">データを完全に削除</button>
                <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">キャンセル</button>
            </div>
        </form>
    </div>
</div>
