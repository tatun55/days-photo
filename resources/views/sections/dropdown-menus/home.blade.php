@if($album->group_id === null)
    <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-album-{{ $album->id }}"><span class="fas fa-book me-2"></span>ミニアルバムを作る</button>
    <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-title-{{ $album->id }}"><span class="fas fa-redo me-2"></span>タイトルの変更</button>
    <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $album->id }}"><span class="fas fa-times-circle me-2"></span>アーカイブ</button>
@else
    <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-album-{{ $album->id }}"><span class="fas fa-book me-2"></span>ミニアルバムを作る</button>
    <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-auto-save-{{ $album->id }}"><span class="fas fa-check me-2"></span>自動保存の承認</button>
@endif
