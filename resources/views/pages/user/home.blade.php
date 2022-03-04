@extends('layouts.app')

@section('content')
<main>
    <div class="section section-lg pt-5 pt-md-6">
        <div class="container">
            <div class="row pt-4 pt-md-0">

                <div class="col-12 col-lg-4 my-3 mb-lg-0">
                    <div class="card border-gray-300 px-3 py-2">
                        <div class="card-header bg-white border-0 text-center d-flex flex-row flex-lg-column align-items-center justify-content-between justify-lg-content-center px-1 px-lg-4">
                            <div class="d-flex justyfy-content-between d-lg-inline flex-row align-items-center">
                                <div class="profile-thumbnail dashboard-avatar mx-lg-auto me-3 ">
                                    <img src="{{ Auth::user()->avatar ?? null }}" class="card-img-top rounded-circle border-white" alt="">
                                </div>
                                <span class="h5 my-0 my-lg-2 me-3 me-lg-0 d-lg-inline-block">{{ Auth::user()->name ?? null }}</span>
                            </div>
                            <button class="btn btn-link dropdown-toggle dropdown-toggle-split me-2 m-0 p-0 d-lg-none" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="icon icon-sm"><span class="fas fa-ellipsis-h icon-secondary fa-lg"></span> </span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu d-lg-none">
                                <a href="" class="list-group-item list-group-item-action border-0"><span class="me-2"><span class="fas fa-user"></span></span>プロフィール</a>
                                <a href="" class="list-group-item list-group-item-action border-0"><span class="me-2"><span class="fas fa-cog"></span></span>設定</a>
                                <a href="{{ route('logout') }}" class="d-flex list-group-item border-0 list-group-item-action"><span class="me-2"><span class="fas fa-sign-out-alt"></span></span>ログアウト</a>
                            </div>
                        </div>

                        {{-- LG幅以上のサイドメニュー --}}
                        <div class="card-body p-2 d-none d-lg-block">
                            <div class="list-group dashboard-menu list-group-sm">
                                <a href="" class="d-flex list-group-item border-0 list-group-item-action"><span class="me-2"><span class="fas fa-user"></span></span>プロフィール<span class="icon icon-xs ms-auto"><span class="fas fa-chevron-right"></span></span></a>
                                <a href="" class="d-flex list-group-item border-0 list-group-item-action"><span class="me-2"><span class="fas fa-cog"></span></span>設定<span class="icon icon-xs ms-auto"><span class="fas fa-chevron-right"></span></span></a>
                                <a href="{{ route('logout') }}" class="mt-2 btn btn-gray-200 btn-sm"><span class="me-2"><span class="fas fa-sign-out-alt"></span></span>ログアウト</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-8 mt-4 mt-lg-3">

                    {{-- タブメニュー --}}
                    <nav>
                        <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active"><span class="fas fa-images me-1"></span>アルバム</a>
                            <a href="{{ route('trashbox') }}" class="nav-item nav-link"><span class="fas fa-trash me-1"></span>アーカイブ</a>
                        </div>
                    </nav>

                    <div class="row">
                        <div class="col-12">
                            <ul class="list-unstyled news-list">
                                @foreach($albums as $album)
                                    <li class="d-flex mx-0 mb-4 w-100">
                                        <a href="{{ route('albums.show',$album->id) }}" class="album-thumbnail-link">
                                            <div class="img-wrapper-1x1">
                                                <div class="img-content">
                                                    <img class="rounded" src="{{ \Storage::disk('s3')->url("/s/{$album->cover}.jpg") }}">
                                                </div>
                                            </div>
                                        </a>
                                        <div style="width:100%">
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('albums.show',$album->id) }}" class="h5 m-0 me-2 p-0">{{ $album->title }}</a>
                                                <div>
                                                    <button class="btn btn-link dropdown-toggle dropdown-toggle-split me-2 m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="icon icon-sm"><span class="fas fa-ellipsis-h icon-secondary fa-lg"></span> </span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-title-{{ $album->id }}"><span class="me-2"><span class="fas fa-edit"></span></span>タイトル変更</button>
                                                        <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $album->id }}"><span class="me-2"><span class="fas fa-trash"></span></span>アーカイブへ移動</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="post-meta font-small">
                                                <span class="me-3"><span class="far fa-clock me-2"></span>{{ $album->created_at->format('Y-m-d H:i') }}</span>
                                                <a href="{{ route('albums.show',$album->id) }}" class="text-secondary"><span class="fa fa-camera me-2"></span>{{ $album->images_count }}</a>
                                            </div>
                                        </div>
                                    </li>

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
