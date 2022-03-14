<!DOCTYPE html>
<html lang="ja">

<head>

    <!-- Basic Page Needs ================================================== -->
    <meta charset="utf-8">
    <title>days. -かんたんフォト管理-</title>
    <meta name="title" content="days. かんたんフォト管理">
    <meta name="description" content="簡単＆無料で、写真がずっと残せるサービスをお探しですか？ 『days.』は新しい ”かんたんフォト管理サービス”。LINE™から友だち登録すると「ずっと残る保存」が無料✨ 「部屋にかざれるアルバム」をポチッと手間なし作成👌" />
    <meta name="author" content="days.運営">
    <meta name="keywords" content="写真をずっと残す方法,オンラインストレージ,チェキ,カード,アルバム,写真,友達,カップル,卒業,記念,思い出,スクラップブック,album,photo," />

    <!-- Mobile Specific Metas ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="theme-color" content="#212121" />
    <meta name="msapplication-navbutton-color" content="#212121" />
    <meta name="apple-mobile-web-app-status-bar-style" content="#212121" />

    <!-- Web Fonts ================================================== -->
    {{-- <link href="https://fonts.googleapis.com/css?family=Montserrat:700" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700" rel="stylesheet" />

    <!-- CSS ================================================== -->
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

    <div class="hero container">
        <div class="row">
            <div class="col-md-12 parallax-fade-top">
                <h5 class="text-center mt-22">いつか消えてしまう、あの写真も、ずっと残る。</h5>
                <p class="lead text-center">『days.』は新しいタイプの かんたんフォト管理 サービス<br>”ずっと残る保存” や ”部屋に飾れるミニアルバム” がスグに</p>
            </div>
        </div>
    </div>

    <!-- Primary Page Layout ================================================== -->

    <main>
        <nav class="menu">
            <div class="menu__item">
                <span class="menu__item-textwrap"><span class="menu__item-text"><span class="menu__item-text-in">pet</span></span>
                </span>
                <a class="menu__item-link"><i class="fa fa-long-arrow-right mr-2"></i>Click here</a>
            </div>
            <div class="menu__item">
                <span class="menu__item-textwrap"><span class="menu__item-text"><span class="menu__item-text-in">trip</span></span>
                </span>
                <a class="menu__item-link"><i class="fa fa-long-arrow-right mr-2"></i>Click here</a>
            </div>
            {{-- <div class="menu__item">
                <span class="menu__item-textwrap"><span class="menu__item-text"><span class="menu__item-text-in">Couple</span></span>
                </span>
                <a class="menu__item-link"><i class="fa fa-long-arrow-right mr-2"></i>Click here</a>
            </div>
            <div class="menu__item">
                <span class="menu__item-textwrap"><span class="menu__item-text"><span class="menu__item-text-in">Personal</span></span>
                </span>
                <a class="menu__item-link"><i class="fa fa-long-arrow-right mr-2"></i>Click here</a>
            </div> --}}
        </nav>
        <div class="page page--preview">
            <div class="gridwrap">
                <div class="grid grid--layout-1">
                    <span class="grid__item tipped" data-title="<em>PET</em><strong>部屋が華やかに</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(img/pet-01-size-m.jpg)">
                        <div class="grid-item-mask"></div>
                    </span>
                    <span class="grid__item tipped" data-title="<em>PET</em><strong>ちょうどいいサイズ</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(img/pet-02-size-m.jpg)">
                        <div class="grid-item-mask"></div>
                    </span>
                    <span class="grid__item tipped" data-title="<em>PET</em><strong>タテヨコ両対応</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(img/pet-03-size-m.jpg)">
                        <div class="grid-item-mask"></div>
                    </span>
                    <span class="grid__item tipped" data-title="<em>PET</em><strong>メッセージカード付</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(img/pet-04-size-m.jpg)">
                        <div class="grid-item-mask"></div>
                    </span>
                </div>
                <div class="grid grid--layout-2">
                    <span class="grid__item tipped" data-title="<em>TRIP</em><strong>部屋が華やかに</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(img/trip-01-size-m.jpg)">
                        <div class="grid-item-mask"></div>
                    </span>
                    <span class="grid__item tipped" data-title="<em>TRIP</em><strong>ちょうどいいサイズ</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(img/trip-02-size-m.jpg)">
                        <div class="grid-item-mask"></div>
                    </span>
                    <span class="grid__item tipped" data-title="<em>TRIP</em><strong>タテヨコ両対応</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(img/trip-03-size-m.jpg)">
                        <div class="grid-item-mask"></div>
                    </span>
                    <span class="grid__item tipped" data-title="<em>TRIP</em><strong>メッセージカード付</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(img/trip-04-size-m.jpg)">
                        <div class="grid-item-mask"></div>
                    </span>
                </div>
                <button class="gridback"><span><i class="fa fa-rotate-left mr-2"></i>back</span></button>
            </div>
            <!-- /gridwrap -->
            <div class="content mb-5">
                <div class="content__item">
                    <p class="lead">スマホに溜まった画像を無料で <b>ずっと残る保存</b><br>保存データをかんたん操作で、ポチッとアルバム化👌</p>
                </div>
                <div class="content__item">
                    <p class="lead">グループでシェアした写真を自動で <b>ずっと残る保存</b><br>グループでの写真の共有・編集が超かんたん👌</p>
                </div>
                {{-- <div class="content__item">
                    <p class="lead">恋人同士でシェアした画像がそのまま記念アルバムに<br>オンラインに “ずっと残る保存” もできる👌</p>
                </div>
                <div class="content__item">
                    <p class="lead">パーソナルなフォトダイアリーにも最適<br>手作りスクラップブックもできる👌</p>
                </div> --}}
            </div>
        </div>
        <!-- /page -->
    </main>

    {{-- QR code --}}
    @include('sections.qrcode')

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
