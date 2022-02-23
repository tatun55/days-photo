@extends('layouts.app')

@section('content')
<main>
    <div class="section section-lg pt-5 pt-md-6">
        <div class="container">
            <div class="row pt-5 pt-md-0">

                <!--Breadcrumb-->
                <nav class="ms-2 mb-0" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fas fa-home"></span></span> ホーム</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $album->title }}</li>
                    </ol>
                </nav>
                <!--End of Breadcrumb-->
                <div class="col-12 col-lg-4 mb-3 mb-lg-0">
                    <div class="card border-gray-300 px-3 py-2">
                        <div class="card-header bg-white border-0 text-center d-flex flex-row flex-lg-column align-items-center justify-content-between justify-lg-content-center px-1 px-lg-4">
                            <div class="d-flex justyfy-content-between d-lg-inline flex-row align-items-center">
                                <div class="col-lg-9 col-3 mx-lg-auto me-3">
                                    <img src="{{ \Storage::disk('s3')->url("/t/{$album->cover}.jpg") }}" class="img-1x1 rounded" alt="">
                                </div>
                                <span class="h5 my-0 my-lg-2 me-3 me-lg-0 d-lg-inline-block">{{ $album->title }}</span>
                            </div>
                            <button class="btn btn-link dropdown-toggle dropdown-toggle-split me-2 m-0 p-0 d-lg-none" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="icon icon-sm"><span class="fas fa-ellipsis-h icon-secondary fa-lg"></span> </span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu d-lg-none">
                                <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-default-{{ $album->id }}"><span class="me-2"><span class="fas fa-edit"></span></span>タイトル変更</button>
                                <a href="" class="list-group-item border-0 list-group-item-action"><span class="me-2"><span class="fas fa-trash"></span></span>削除 (ごみ箱へ移動)</a>
                                <a href="" class="list-group-item border-0 list-group-item-action"><span class="me-2"><span class="fas fa-times-circle"></span></span>削除 (データの消去)</a>
                            </div>
                        </div>

                        {{-- LG幅以上のサイドメニュー --}}
                        <div class="card-body p-2 d-none d-lg-block">
                            <div class="list-group dashboard-menu list-group-sm">
                                <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-default-{{ $album->id }}"><span class="me-2"><span class="fas fa-edit"></span></span>タイトル変更</button>
                                <a href="" class="list-group-item border-0 list-group-item-action"><span class="me-2"><span class="fas fa-trash"></span></span>削除 (ごみ箱へ移動)</a>
                                <a href="" class="list-group-item border-0 list-group-item-action"><span class="me-2"><span class="fas fa-times-circle"></span></span>削除 (データの消去)</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modal-default-{{ $album->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
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

                <div class="col-12 col-lg-8 mt-4 mt-lg-0">
                    <div class="row">
                        <div class="col-12">
                            <ul class="list-unstyled news-list d-flex flex-wrap">
                                @foreach($album->images()->orderBy('index','asc')->get() as $image)
                                    <li class="" style="width:33.3%; padding:0.5%;">
                                        <a href="" class="col-5">
                                            <img class="img-1x1" src="{{ \Storage::disk('s3')->url("/t/{$image->id}.jpg") }}">
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
