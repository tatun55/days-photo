<!DOCTYPE html>
<html lang="ja">

<head>

    <!-- Basic Page Needs ================================================== -->
    <meta charset="utf-8">
    <title>days.</title>
    <meta name="description" content="いつか消えてしまう、あの写真も、ずっと残る。 友だち登録するだけでチェキ風写真・アルバムが無料✨　プリンタで無料印刷 or ポチッと発送 ✅　アルバムもポチッと注文OK ✅" />
    <meta name="author" content="days.運営">
    <meta name="keywords" content="チェキ,カード,アルバム,写真,友達,カップル,卒業,記念,思い出,スクラップブック,album,photo," />

    <!-- Mobile Specific Metas ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="theme-color" content="#212121" />
    <meta name="msapplication-navbutton-color" content="#212121" />
    <meta name="apple-mobile-web-app-status-bar-style" content="#212121" />

    <!-- Web Fonts ================================================== -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700" rel="stylesheet" />

    <!-- CSS ================================================== -->
    <link rel="stylesheet" href="lp/css/bootstrap.min.css" />
    <link rel="stylesheet" href="lp/css/font-awesome.min.css" />
    <link rel="stylesheet" href="lp/css/style.css" />
    <link rel="stylesheet" href="lp/css/colors/color.css" />
    <link rel="stylesheet" href="lp/css/retina.css" />
    <link rel="stylesheet" href="lp/css/app.css" />

    <!-- Favicons ================================================== -->
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="./apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="./apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="./apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="./apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="./apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="./apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="./apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="./apple-touch-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon-180x180.png" />

</head>

<body class="royal_preloader">

    <div id="royal_preloader"></div>

    <!-- Nav and Logo ================================================== -->

    <header class="cd-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ml-3 mr-md-3">
                    <div class="logo-wrap">
                        <a class="h4 navbar-brand" href="/">days.</a>
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

    <div class="hero container">
        <div class="row">
            <div class="col-md-12 parallax-fade-top">
                <h5 class="text-center mt-22">いつか消えてしまう、あの写真も、ずっと残る。</h5>
                <p class="lead text-center">『days.』は新しいタイプの <b>かんたんフォト管理</b> サービス<br>アルバムの <b>ワンクリック作成</b> や <b>ずっと残る保存</b> が無料でスグに</p>
            </div>
        </div>
    </div>

    <div class="nav">
        <div class="nav__content">
            <ul class="nav__list">
                @auth('web')
                    <li class="nav__list-item"><a href="/home">home</a></li>
                @endauth
                <li class="nav__list-item active-nav"><a href="/">intro</a></li>
                <li class="nav__list-item"><a href="/">about</a></li>
                <li class="nav__list-item"><a href="/">contact</a></li>
            </ul>
        </div>
        <div class="nav__footer">
            <p>2022 © <a href="https://colorbox.tech">COLORBOX Inc.</a></p>
        </div>
    </div>

    <!-- Primary Page Layout ================================================== -->

    <main>
        <nav class="menu">
            <div class="menu__item">
                <span class="menu__item-textwrap"><span class="menu__item-text"><span class="menu__item-text-in">Friend</span></span>
                </span>
                <a class="menu__item-link"><i class="fa fa-long-arrow-right mr-2"></i>Click here</a>
            </div>
            <div class="menu__item">
                <span class="menu__item-textwrap"><span class="menu__item-text"><span class="menu__item-text-in">Family</span></span>
                </span>
                <a class="menu__item-link"><i class="fa fa-long-arrow-right mr-2"></i>Click here</a>
            </div>
            <div class="menu__item">
                <span class="menu__item-textwrap"><span class="menu__item-text"><span class="menu__item-text-in">Couple</span></span>
                </span>
                <a class="menu__item-link"><i class="fa fa-long-arrow-right mr-2"></i>Click here</a>
            </div>
            <div class="menu__item">
                <span class="menu__item-textwrap"><span class="menu__item-text"><span class="menu__item-text-in">Personal</span></span>
                </span>
                <a class="menu__item-link"><i class="fa fa-long-arrow-right mr-2"></i>Click here</a>
            </div>
        </nav>
        <div class="page page--preview">
            <div class="gridwrap">
                <div class="grid grid--layout-1">
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/1.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/2.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/3.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/4.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/5.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/6.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/7.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/8.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/9.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                </div>
                <div class="grid grid--layout-2">
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/10.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/11.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/12.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/13.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/14.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/15.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/16.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/17.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                </div>
                <div class="grid grid--layout-3">
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/18.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/19.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/20.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/21.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/22.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/23.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/24.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/42.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/43.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                </div>
                <div class="grid grid--layout-4">
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/25.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/26.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/27.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/28.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/29.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/30.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/31.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/32.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                </div>
                <div class="grid grid--layout-5">
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/33.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/34.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/35.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/36.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/37.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/38.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/39.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/40.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                    <a href="project.html" class="grid__item tipped" data-title="<em>Nature</em><strong>Your Title</strong>" data-tipper-options='{"direction":"bottom","follow":"true","margin":25}' style="background-image: url(lp/img/portfolio/41.jpg)">
                        <div class="grid-item-mask"></div>
                    </a>
                </div>
                <button class="gridback "><span><i class="fa fa-rotate-left mr-2"></i>go back</span></button>
            </div>
            <!-- /gridwrap -->
            <div class="content mb-5">
                <div class="content__item">
                    <p class="lead">友だちに送った写真をカード型に自動変換<br>写真はポチッと無料印刷 / 郵送 / アルバム化👌</p>
                </div>
                <div class="content__item">
                    <p class="lead">家族アルバムの作成にも days.（デイズ）<br>ぜったい忘れずに、定期的に自動でできるので安心👌</p>
                </div>
                <div class="content__item">
                    <p class="lead">恋人同士のLINEトークがそのまま記念アルバムに<br>オリジナルスクラップブックもOK👌</p>
                </div>
                <div class="content__item">
                    <p class="lead">パーソナルなフォトダイアリーにも最適<br>手作りスクラップブックも簡単👌</p>
                </div>
            </div>
        </div>
        <!-- /page -->
    </main>

    @include('sections.qrcode')

    {{-- <div class="container padding-top padding-bottom">
        <div class="row">
            <div class="col-md-12 footer">
                <p>2022 © <a href="https://colorbox.tech">COLORBOX Inc.</a></p>
            </div>
        </div>
    </div> --}}
    <footer class="footer pt-5 pb-5 bg-white text-gray">
        <div class="container">
            <div class="d-flex justify-content-center text-center">
                <a class="px-2" href="{{ route('terms') }}" type="button">利用規約</a>
                <a class="px-2" href="{{ route('pp') }}" type="button">プライバシーポリシー</a>
                <a class="px-2" href="{{ route('ld') }}" type="button">特定商取引法表示</a>
            </div>
            <div class="text-center mt-4">
                <div class="brand mb-1"><small>2022 - ©</small> <a class="px-3 d-inline-block" href="https://days.photo">days. </a><small>かんたんフォト管理</small></div>
                <div class="produce">produced by <a href="https://colorbox.tech">COLORBOX Inc.</a></div>
            </div>
        </div>
    </footer>

    <script src="lp/js/jquery.min.js"></script>
    <script src="lp/js/royal_preloader.min.js"></script>
    <script src="lp/js/popper.min.js"></script>
    <script src="lp/js/bootstrap.min.js"></script>
    <script src="lp/js/plugins.js"></script>
    <script src="lp/js/animated-grid-portfolio.js"></script>
    <script src="lp/js/custom.js"></script>

</body>

</html>
