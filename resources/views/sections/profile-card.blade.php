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
                <a href="{{ route('account') }}" class="list-group-item list-group-item-action border-0"><span class="me-2"><span class="fas fa-user"></span></span>アカウントサービス</a>
                <a href="" class="list-group-item list-group-item-action border-0"><span class="me-2"><span class="fas fa-cog"></span></span>設定</a>
                <a href="{{ route('logout') }}" class="d-flex list-group-item border-0 list-group-item-action"><span class="me-2"><span class="fas fa-sign-out-alt"></span></span>ログアウト</a>
            </div>
        </div>

        {{-- LG幅以上のサイドメニュー --}}
        <div class="card-body p-2 d-none d-lg-block">
            <div class="list-group dashboard-menu list-group-sm">
                <a href="{{ route('account') }}" class="d-flex list-group-item border-0 list-group-item-action"><span class="me-2"><span class="fas fa-user"></span></span>アカウントサービス<span class="icon icon-xs ms-auto"><span class="fas fa-chevron-right"></span></span> </a>
                <a href="" class="d-flex list-group-item border-0 list-group-item-action"><span class="me-2"><span class="fas fa-cog"></span></span>設定<span class="icon icon-xs ms-auto"><span class="fas fa-chevron-right"></span></span> </a>
                <a href="{{ route('logout') }}" class="mt-2 btn btn-gray-200 btn-sm"><span class="me-2"><span class="fas fa-sign-out-alt"></span></span>ログアウト</a>
            </div>
        </div>
    </div>
</div>
