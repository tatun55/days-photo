@extends('layouts.app')

@section('content')
<main>
    <div class="section section-lg pt-5 pt-md-6">
        <div class="container">
            <div class="row pt-5 pt-md-0">

                <!--Breadcrumb-->
                <nav class="ms-2 mb-0" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><span class="fas fa-home"></span></span> ホーム</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$album->title}}</li>
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
                    <div class="row">
                        <div class="col-12">
                            <ul class="list-unstyled news-list d-flex flex-wrap">
                                @foreach($album->images()->get() as $image)
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
