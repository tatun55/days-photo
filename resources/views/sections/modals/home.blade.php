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
    @if($album->group_id !== null)
        <div class="modal fade" id="modal-save-setting-{{ $album->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-save-setting-{{ $album->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form method="POST" action="{{ route('albums.auto-saving',$album->id) }}" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h2 class="h6 modal-title">ずっと残る保存の設定</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="save" id="save1-{{ $album->id }}" value="1" @if($album->group->users[0]->pivot->auto_saving === 1) checked @endif>
                            <label for="save1-{{ $album->id }}">自分がシェア投稿した画像を保存</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="save" id="save2-{{ $album->id }}" value="0" @if($album->group->users[0]->pivot->auto_saving === 0) checked @endif>
                            <label class="form-check-label" for="save2-{{ $album->id }}">自分がシェア投稿した画像を保存しない</label>
                            {{-- <label class="form-check-label" for="save3"><input class="form-check-input" type="radio" name="save" id="save3" value="0">グループに自分がシェア投稿した画像を保存しない</label> --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning text-white">設定を変更</button>
                        <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">キャンセル</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

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
