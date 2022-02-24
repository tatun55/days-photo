@extends('layouts.app')

@section('content')
<main>
    <div class="section section-lg pt-5 pt-md-6">
        <div class="container">
            <div class="row pt-5 pt-md-0">
                <div class="col-12 col-lg-4 mb-3 mb-lg-0">
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
                                <a href="" class="d-flex list-group-item border-0 list-group-item-action"><span class="me-2"><span class="fas fa-user"></span></span>プロフィール<span class="icon icon-xs ms-auto"><span class="fas fa-chevron-right"></span></span> </a>
                                <a href="" class="d-flex list-group-item border-0 list-group-item-action"><span class="me-2"><span class="fas fa-cog"></span></span>設定<span class="icon icon-xs ms-auto"><span class="fas fa-chevron-right"></span></span> </a>
                                <a href="{{ route('logout') }}" class="mt-2 btn btn-gray-200 btn-sm"><span class="me-2"><span class="fas fa-sign-out-alt"></span></span>ログアウト</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-8 mt-4 mt-lg-0">

                    {{-- タブメニュー --}}
                    <nav>
                        <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link" href="{{ route('home') }}"><span class="fas fa-images me-1"></span>アルバム</a>
                            <a class="nav-item nav-link active"><span class="fas fa-trash me-1"></span>ごみ箱</a>
                        </div>
                    </nav>

                    <div class="row">
                        <div class="col-12">
                            <ul class="list-unstyled news-list">
                                @foreach($trashedAlbums as $album)
                                    <li class="row mx-0 mb-4">
                                        <div class="col-5">
                                            <div class="img-wrapper-1x1">
                                                <div class="img-content">
                                                    <img class="rounded" src="{{ \Storage::disk('s3')->url("/t/{$album->cover}.jpg") }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="d-flex justigy-content-between">
                                                <h5 class="h5 m-0 me-2 p-0">{{ $album->title }}</h5>
                                                <button class="btn btn-link dropdown-toggle dropdown-toggle-split me-2 m-0 p-0 d-lg-none" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="icon icon-sm"><span class="fas fa-ellipsis-h icon-secondary fa-lg"></span> </span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu d-lg-none">
                                                    <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-restore-{{ $album->id }}"><span class="fas fa-redo me-2"></span>元に戻す</button>
                                                    <button type="button" class="list-group-item list-group-item-action border-0" data-bs-toggle="modal" data-bs-target="#modal-force-delete-{{ $album->id }}"><span class="fas fa-times-circle me-2"></span>削除 (データの消去)</button>
                                                </div>
                                            </div>
                                            <div class="post-meta font-small">
                                                <span class="me-3"><span class="far fa-clock me-2"></span>{{ $album->created_at->format('Y-m-d H:i') }}</span>
                                                <span class="text-secondary"><span class="fa fa-camera me-2"></span>{{ $album->images_count }}</span>
                                            </div>
                                        </div>
                                    </li>

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
