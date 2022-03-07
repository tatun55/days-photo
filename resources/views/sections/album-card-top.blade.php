<div class="col-12 col-lg-4 mb-3 mb-lg-0">
    <div class="card border-gray-300 px-3 py-2">
        <div class="card-header bg-white border-0 text-center d-flex flex-row flex-lg-column align-items-top justify-content-between justify-lg-content-center px-1 px-lg-4">
            <div class="d-flex justyfy-content-between d-lg-inline flex-row align-items-top">
                <div class="profile-thumbnail mx-lg-auto me-3">
                    <div class="img-wrapper-1x1">
                        <div class="img-content">
                            <img class="rounded" src="{{ \Storage::disk('s3')->url("/s/{$album->cover}.jpg") }}">
                        </div>
                    </div>
                </div>
                <span class="h5 my-0 mt-lg-3 me-3 me-lg-0 d-inline-block text-left">
                    {{ $album->title }}
                    <div class="post-meta font-small">
                        <span class="me-3"><span class="far fa-clock me-2"></span>{{ $album->created_at->format('Y-m-d H:i') }}</span>
                        <span class="text-secondary"><span class="fa fa-camera me-2"></span>{{ $album->images()->count() }}</span>
                    </div>
                </span>
            </div>
            <div class="d-lg-none">
                <button class="btn btn-link dropdown-toggle dropdown-toggle-split me-2 m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="icon icon-sm"><span class="fas fa-ellipsis-h icon-secondary fa-lg"></span> </span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu d-lg-none">
                    <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-album-{{ $album->id }}"><span class="me-2"><span class="fas fa-book-open"></span></span>ミニアルバムを注文</button>
                    <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-title-{{ $album->id }}"><span class="me-2"><span class="fas fa-edit"></span></span>タイトル変更</button>
                    <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $album->id }}"><span class="me-2"><span class="fas fa-trash"></span></span>アーカイブへ移動</button>
                </div>
            </div>
        </div>

        {{-- LG幅以上のサイドメニュー --}}
        <div class="card-body p-2 d-none d-lg-block">
            <div class="list-group dashboard-menu list-group-sm">
                <a type="button" class="d-flex list-group-item border-0 list-group-item-action" data-bs-toggle="modal" data-bs-target="#modal-album-{{ $album->id }}"><span class="me-2"><span class="fas fa-book-open"></span></span>ミニアルバムを注文<span class="icon icon-xs ms-auto"><span class="fas fa-chevron-right"></span></span></a>
                <a type="button" class="d-flex list-group-item border-0 list-group-item-action" data-bs-toggle="modal" data-bs-target="#modal-title-{{ $album->id }}"><span class="me-2"><span class="fas fa-edit"></span></span>タイトル変更<span class="icon icon-xs ms-auto"><span class="fas fa-chevron-right"></span></span></a>
                <a type="button" class="d-flex list-group-item border-0 list-group-item-action" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $album->id }}"><span class="me-2"><span class="fas fa-trash"></span></span>アーカイブへ移動<span class="icon icon-xs ms-auto"><span class="fas fa-chevron-right"></span></span></a>
            </div>
        </div>
    </div>
</div>
