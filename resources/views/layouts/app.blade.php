<!DOCTYPE html>
<html lang="ja">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>days.</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta name="title" content="days. - かんたんフォト管理 - ">
    <meta name="author" content="COLORBOX Inc.">
    <meta name="description" content="いつか消えてしまう、あの写真も、ずっと残る。 days.は新しいタイプの “かんたんフォト管理” サービス。ずっと残る保存が無料✅ 部屋にかざれるアルバムがスグに✅">
    <link type="text/css" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('css/pixel.css') }}" rel="stylesheet">
    @isset($photoSwipe)
        <link rel="stylesheet" href="{{ asset('photoswipe/v5/photoswipe.css') }}" />
    @endisset
    @yield('style')
    <link type="text/css" href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <header class="header-global">
        <nav id="navbar-main" aria-label="Primary navigation" class="navbar navbar-main navbar-expand-lg nav-theme-white navbar-light mt-2">
            @isset($isReview)
                <div class="container position-relative">
                    <span class="brand-name me-lg-5 px-2 px-lg-0">days.</span>
                </div>
            @else
                <div class="container position-relative">
                    <a class="brand-name me-lg-5 px-2 px-lg-0" href="{{ route('home') }}">days.</a>
                    <div class="navbar-collapse collapse me-auto" id="navbar_global">
                        <div class="navbar-collapse-header">
                            <div class="row">
                                <div class="col-6 collapse-brand"><a href="/">days.</a></div>
                                <div class="col-6 collapse-close"><a href="#navbar_global" class="fas fa-times" data-bs-toggle="collapse" data-bs-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" title="close" aria-label="Toggle navigation"></a></div>
                            </div>
                        </div>
                        <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
                        </ul>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('cart') }}" class="text-primary"><span class="fa fa-shopping-cart me-2 fs-5 position-relative">@if(\Auth::user()->cartItems()->get()->isNotEmpty())<span class="badge-num"></span>@endif</span></a>
                    </div>
                </div>
            @endisset
        </nav>
    </header>

    @include('sections.toast')

    <div class="wrapper bg-white">
        @yield('content')
        <div class="push"></div>
    </div>

    <footer class="footer pt-5 pb-5 bg-white text-gray">


        <div class="container">


            <div class="row">
                @isset($isReview)
                    <div class="col-md-12 text-center">
                        <div class="brand mb-1"><small>2022 - ©</small><span class="btn-light px-2 d-inline-block">days.</span><small>かんたんフォト管理</small></div>
                        <div class="produce">produced by <span class="btn-light">COLORBOX Inc.</span></div>
                    </div>
                @else
                    <div class="d-flex justify-content-center mb-4">
                        <a class="px-2" href="{{ route('terms') }}" type="button">利用規約</a>
                        <a class="px-2" href="{{ route('pp') }}" type="button">プライバシーポリシー</a>
                        <a class="px-2" href="{{ route('ld') }}" type="button">特定商取引法表示</a>
                    </div>
                    <div class="col-md-12 text-center">
                        <div class="brand mb-1"><small>2022 - ©</small><a class="btn-light px-2 d-inline-block" href="https://days.photo">days.</a><small>かんたんフォト管理</small></div>
                        <div class="produce">produced by <a class="btn-light" href="https://colorbox.tech">COLORBOX Inc.</a></div>
                    </div>
                @endisset

            </div>
        </div>

    </footer>

    <!-- Core -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('vendor/@popperjs/core/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/headroom.js/dist/headroom.min.js') }}"></script>
    <!-- Vendor JS -->
    <script src="{{ asset('vendor/onscreen/dist/on-screen.umd.min.js') }}"></script>
    <script src="{{ asset('vendor/jarallax/dist/jarallax.min.js') }}"></script>
    <script src="{{ asset('vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js') }}"></script>
    <script src="{{ asset('vendor/vivus/dist/vivus.min.js') }}"></script>
    <script src="{{ asset('vendor/vanillajs-datepicker/dist/js/datepicker.min.js') }}"></script>
    <script async defer="defer" src="{{ asset('https://buttons.github.io/buttons.js') }}"></script>
    <!-- Pixel JS -->
    <script src="{{ asset('assets/js/pixel.js') }}"></script>
    <script src="{{ asset('js/toast.js') }}" type="module"></script>
    @include('sections.modal')
    @isset($photoSwipe)
        @include('sections.photoswipe.script')
    @endisset
    @yield('script')
</body>

</html>
