@extends('layouts.app',['photoSwipe' => true])

@section('content')
<main>
    <section id="album" class="section section-lg pt-5 pt-md-6">
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

                @include('sections.album-card-top')

                <div class="col-12 col-lg-8 mt-4 mt-lg-3">
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
                                <input type="submit" id="action-destroy-btn" name="action_destroy" class="d-none">
                                <button id="archive-btn" type="button" class="btn btn-danger mx-2 text-white hide" data-bs-toggle="modal" data-bs-target="#modal-destroy">完全削除</button>
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

        <div class="modal fade" id="modal-destroy" tabindex="-1" role="dialog" aria-labelledby="modal-destroy" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="h6 modal-title">写真を完全に削除しますか？</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <button id="modal-action-destroy-btn" class="btn btn-danger text-white">完全に削除</button>
                        <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">キャンセル</button>
                    </div>
                </div>
            </div>
        </div>

</main>
@endsection

@section('script')
<script type="module">
    var actionDestroyBtn = document.querySelector('#action-destroy-btn');
    var modalActionDestroyBtn = document.querySelector('#modal-action-destroy-btn');
    modalActionDestroyBtn.addEventListener( 'click', function () {
        actionDestroyBtn.click();
    }, false );
</script>
@endsection
