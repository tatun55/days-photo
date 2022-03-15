@foreach($albums as $album)

    <div class="modal fade" id="modal-title-{{ $album->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-title-{{ $album->id }}" aria-hidden="true">
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

    <div class="modal fade" id="modal-delete-{{ $album->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-delete-{{ $album->id }}" aria-hidden="true">
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

    {{-- <div class="modal fade" id="modal-post-album" tabindex="-1" role="dialog" aria-labelledby="modal-post-album" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="POST" class="modal-content" action="{{ route('albums.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h2 class="h6 modal-title">💎 ずっと残るアルバムをつくる</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-4">
            <label for="validationServerUsername">タイトル</label>
            <input type="text" class="form-control" name="title" value="{{ \Carbon\Carbon::now()->format('Y年n月j日に作成') }}" accept="image/*" />
            <div class="form-text text-gray text-right text-sm me-2"><span class="text-danger">*</span> 50字以内</div>
        </div>
        <div class="mb-4">
            <label for="validationServerUsername">アップロード画像を選択</label>
            <input class="form-control" type="file" name="files[]" accept="image/*" multiple>
            <div class="form-text text-gray text-right text-sm me-2"><span class="text-danger">*</span> JPGまたはPNG</div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary text-white">アルバムを作成</button>
        <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">キャンセル</button>
    </div>
    </form>
    </div>
    </div> --}}

    @include('parts.modals.album-order')
@endforeach
