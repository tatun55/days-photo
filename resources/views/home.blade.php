@extends('layouts.app')

@section('content')
<main>
    <div class="section section-lg pt-5 pt-md-6">
        <div class="container">
            <div class="row pt-4 pt-md-0">
                <div class="col-12 col-lg-4 mb-3 mb-lg-0">
                    <div class="card border-gray-300 px-3 py-2">
                        <div class="card-header bg-white border-0 text-center d-flex flex-row flex-lg-column align-items-center justify-content-between justify-lg-content-center px-1 px-lg-4">
                            <div class="d-flex justyfy-content-between d-lg-inline flex-row align-items-center">
                                <div class="profile-thumbnail dashboard-avatar mx-lg-auto me-3 ">
                                    <img src="{{ Auth::user()->avatar ?? null }}" class="card-img-top rounded-circle border-white" alt="">
                                </div>
                                <span class="h5 my-0 my-lg-3 me-3 me-lg-0">{{ Auth::user()->name ?? null }}</span>
                            </div>
                            <button class="btn btn-link dropdown-toggle dropdown-toggle-split me-2 m-0 p-0 d-lg-none" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="icon icon-sm"><span class="fas fa-ellipsis-h icon-secondary fa-lg"></span> </span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                                <a href="./my-items.html" class="list-group-item list-group-item-action d-sm-none border-0">プロフィール</a>
                                <a href="./my-items.html" class="list-group-item list-group-item-action d-sm-none border-0">設定</a>
                            </div>

                            {{-- <a href="#" class="btn btn-gray-300 btn-xs"><span class="me-2"><span class="fas fa-sign-out-alt"></span></span>Sign Out</a> --}}
                        </div>

                        {{-- LG幅以上のサイドメニュー --}}
                        <div class="card-body p-2 d-none d-lg-block">
                            <div class="list-group dashboard-menu list-group-sm">
                                <a href="./account.html" class="d-flex list-group-item border-0 list-group-item-action active">プロフィール<span class="icon icon-xs ms-auto"><span class="fas fa-chevron-right"></span></span> </a>
                                <a href="./settings.html" class="d-flex list-group-item border-0 list-group-item-action">設定<span class="icon icon-xs ms-auto"><span class="fas fa-chevron-right"></span></span> </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-8">
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
