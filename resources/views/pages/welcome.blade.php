@extends('layouts.lp')

@section('content')
<div class="hero container">
    <div class="row">
        <div class="col-md-12 parallax-fade-top">
            <h5 class="text-center mt-22">思い出が整理されてずっと残る、小さな幸せ、安心感。</h5>
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
            <a class="menu__item-link"><i class="fa fa-long-arrow-right mr-2"></i>click</a>
        </div>
        <div class="menu__item">
            <span class="menu__item-textwrap"><span class="menu__item-text"><span class="menu__item-text-in">trip</span></span>
            </span>
            <a class="menu__item-link"><i class="fa fa-long-arrow-right mr-2"></i>click</a>
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
@endsection
