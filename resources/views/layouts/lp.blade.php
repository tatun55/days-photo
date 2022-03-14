<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>days. -かんたんフォト管理-</title>
    <meta name="title" content="days. かんたんフォト管理">
    <meta name="description" content="簡単＆無料で、写真がずっと残せるサービスをお探しですか？ 『days.』は新しい ”かんたんフォト管理サービス”。LINE™から友だち登録すると「ずっと残る保存」が無料✨ 「部屋にかざれるアルバム」をポチッと手間なし作成👌" />
    <meta name="author" content="days.運営">
    <meta name="keywords" content="写真をずっと残す方法,オンラインストレージ,チェキ,カード,アルバム,写真,友達,カップル,卒業,記念,思い出,スクラップブック,album,photo," />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="theme-color" content="#212121" />
    <meta name="msapplication-navbutton-color" content="#212121" />
    <meta name="apple-mobile-web-app-status-bar-style" content="#212121" />

    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('lp/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('lp/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('lp/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('lp/css/colors/color.css') }}" />
    <link rel="stylesheet" href="{{ asset('lp/css/retina.css') }}" />
    <link rel="stylesheet" href="{{ asset('lp/css/app.css') }}" />

    <!-- Favicons ================================================== -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon/">
    <link rel="apple-touch-icon" href="{{ asset('./apple-touch-icon.png') }}" />
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('./apple-touch-icon-57x57.png') }}" />
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('./apple-touch-icon-72x72.png') }}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('./apple-touch-icon-76x76.png') }}" />
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('./apple-touch-icon-114x114.png') }}" />
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('./apple-touch-icon-120x120.png') }}" />
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('./apple-touch-icon-144x144.png') }}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('./apple-touch-icon-152x152.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('./apple-touch-icon-180x180.png') }}" />

</head>

<body class="royal_preloader">

    <div id="royal_preloader"></div>

    <!-- Nav and Logo ================================================== -->

    <header class="cd-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ml-3 mr-md-3">
                    <div class="logo-wrap">
                        <a class="h4 navbar-brand" href="{{ url('/') }}">days.</a>
                    </div>
                    <div class="nav-but-wrap">
                        <div class="menu-icon">
                            <span class="menu-icon__line menu-icon__line-left"></span>
                            <span class="menu-icon__line"></span>
                            <span class="menu-icon__line menu-icon__line-right"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="nav">
        <div class="nav__content">
            <ul class="nav__list">
                @auth('web')
                    <li class="nav__list-item"><a href="/home">home</a></li>
                @endauth
                <li class="nav__list-item active-nav"><a href="/">intro</a></li>
                {{-- <li class="nav__list-item"><a href="{{ route('about') }}">about</a></li>
                <li class="nav__list-item"><a href="/">contact</a></li> --}}
            </ul>
        </div>
        <div class="nav__footer">
            <div class="text-center mt-4">
                <div class="brand mb-1"><small>2022 - ©</small><a class="px-2 d-inline-block" href="https://days.photo">days.</a><small>かんたんフォト管理</small></div>
                <div class="produce">produced by <a href="https://colorbox.tech">COLORBOX Inc.</a></div>
            </div>
        </div>
    </div>

    @yield('content')

    <footer class="footer pt-5 pb-5 bg-white text-gray">
        <div class="container">
            <div class="d-flex justify-content-center text-center">
                <a class="px-2" href="{{ route('terms') }}" type="button">利用規約</a>
                <a class="px-2" href="{{ route('pp') }}" type="button">プライバシーポリシー</a>
                <a class="px-2" href="{{ route('ld') }}" type="button">特定商取引法表示</a>
            </div>
            <div class="text-center mt-4">
                <div class="brand mb-1"><small>2022 - ©</small><a class="px-2 d-inline-block" href="https://days.photo">days.</a><small>かんたんフォト管理</small></div>
                <div class="produce">produced by <a href="https://colorbox.tech">COLORBOX Inc.</a></div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('lp/js/jquery.min.js') }}"></script>
    <script src="{{ asset('lp/js/royal_preloader.min.js') }}"></script>
    <script src="{{ asset('lp/js/popper.min.js') }}"></script>
    <script src="{{ asset('lp/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('lp/js/plugins.js') }}"></script>
    <script src="{{ asset('lp/js/animated-grid-portfolio.js') }}"></script>
    <script src="{{ asset('lp/js/custom.js') }}"></script>

</body>

</html>
