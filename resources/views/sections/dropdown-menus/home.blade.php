@if($album->group_id === null)
    <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-album-{{ $album->id }}"><span class="fas fa-book me-2"></span>ミニアルバムを作る</button>
    <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-title-{{ $album->id }}"><span class="fas fa-redo me-2"></span>タイトルの変更</button>
    <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $album->id }}"><span class="fas fa-trash me-2"></span>アーカイブ</button>
@else
    <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-album-{{ $album->id }}"><span class="fas fa-book me-2"></span>ミニアルバムを作る</button>
    <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-save-setting-{{ $album->id }}"><span class="fas fa-cog me-2"></span>保存設定</button>
    <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $album->id }}"><span class="fas fa-trash me-2"></span>アーカイブ</button>
@endif
