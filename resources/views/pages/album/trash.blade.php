@extends('layouts.app',['photoSwipe' => true])

@section('content')
<main>
    <div class="section section-lg pt-5 pt-md-6">
        <div class="container">
            <div class="row pt-4 pt-md-0">

                <!--Breadcrumb-->
                <nav class="ms-2 mb-0 mt-4" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fas fa-home"></span></span> ホーム</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $album->title }}</li>
                    </ol>
                </nav>
                <!--End of Breadcrumb-->

                <div class="col-12 col-lg-4 mb-3 mb-lg-0 mt-3">
                    <div class="list-unstyled news-list">
                        <li class="row">
                            <a href="{{ route('albums.show',$album->id) }}" class="col-4 col-lg-12">
                                <div class="img-wrapper-1x1">
                                    <div class="img-content">
                                        <img class="rounded" src="{{ \Storage::disk('s3')->url("/s/{$album->cover}.jpg") }}">
                                    </div>
                                </div>
                            </a>
                            <div class="col col-lg-12">
                                <div class="d-flex justify-content-between">
                                    <h5 class="h5 m-0 me-2 p-0 mt-lg-3">{{ $album->title }}</h5>
                                    <button class="btn btn-link dropdown-toggle dropdown-toggle-split me-2 m-0 p-0 d-lg-none" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="icon icon-sm"><span class="fas fa-ellipsis-h icon-secondary fa-lg"></span> </span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu d-lg-none">
                                        <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-title-{{ $album->id }}"><span class="me-2"><span class="fas fa-edit"></span></span>タイトル変更</button>
                                        <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $album->id }}"><span class="me-2"><span class="fas fa-trash"></span></span>削除 (アーカイブへ移動)</button>
                                    </div>
                                </div>
                                <div class="post-meta font-small">
                                    <span class="me-3"><span class="far fa-clock me-2"></span>{{ $album->created_at->format('Y-m-d H:i') }}</span>
                                    <span class="text-secondary"><span class="fa fa-camera me-2"></span>{{ $album->images()->count() }}</span>
                                </div>
                            </div>
                        </li>
                    </div>
                    {{-- LG幅以上のサイドメニュー --}}
                    <div class="card-body p-2 d-none d-lg-block">
                        <div class="list-group dashboard-menu list-group-sm">
                            <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-title-{{ $album->id }}"><span class="me-2"><span class="fas fa-edit"></span></span>タイトル変更</button>
                            <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $album->id }}"><span class="me-2"><span class="fas fa-trash"></span></span>削除 (アーカイブへ移動)</button>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-8 mt-4 mt-lg-0">
                    {{-- タブメニュー --}}
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a href="{{ route('albums.show',$album->id) }}" class="nav-item nav-link"><span class="fas fa-images me-1"></span>フォト</a>
                            <a class="nav-item nav-link active"><span class="fas fa-trash me-1"></span>アーカイブ</a>
                        </div>
                    </nav>

                    <form id="items-form" action="{{ route('albums.photos.action',$album->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div id="item-menus" class="d-flex p-3 position-sticky bg-white" style="z-index: 999;top:0">
                            <div id="left-btns" class="d-flex justify-content-start w-100">
                                <div id="select-desc" class="form-control-plaintext w-auto mx-2 hide"><span class="fas fa-info-circle me-1"></span>写真を選択してください</div>
                                <input type="submit" id="move-btn" name="action_restore" class="btn btn-primary mx-2 text-white hide" value="元に戻す">
                                <input type="submit" id="archive-btn" name="action_destroy" class="btn btn-danger mx-2 text-white hide" value="完全削除">
                            </div>
                            <div id="cancel-btn" class="btn btn-outline-primary w-auto flex-shrink-0 hide">キャンセル</div>
                            <div id="select-btn" class="btn btn-primary flex-shrink-0 hide show">選択</div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <ul class="list-unstyled news-list d-flex flex-wrap">
                                    @foreach($album->images()->onlyTrashed()->orderBy('deleted_at','desc')->get() as $image)
                                        <li class="item" style="width:33.3%; padding:0.5%;">
                                            <div class="img-wrapper-1x1">
                                                <label class="img-content">
                                                    <input name="items[]" type="checkbox" value="{{ $image->index }}" class="hidden-checkbox" disabled><span></span>
                                                    <img data-index="{{ $image->index }}" src="{{ \Storage::disk('s3')->url("/s/{$image->id}.jpg") }}">
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal fade" id="modal-title-{{ $album->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
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

            <div class="modal fade" id="modal-delete-{{ $album->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <form method="POST" action="{{ route('albums.delete',$album->id) }}" class="modal-content">
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

        </div>
    </div>
</main>
@endsection
