@extends('layouts.app')

@section('content')
<main>
    <div class="section">
        <div class="container">
            <div class="row">

                <!--Breadcrumb-->
                <nav class="ms-2 mb-0 mt-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-transparent">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fas fa-home me-1"></span></span>ホーム</a></li>
                        <li class="breadcrumb-item active" aria-current="page">アカウントサービス</li>
                    </ol>
                </nav>
                <!--End of Breadcrumb-->

                @include('sections.profile-card')

                <div class="col-12 col-lg-8 mt-4 mt-lg-3">

                    <nav>
                        <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active"><span class="fas fa-images me-1"></span>プリンター設定</a>
                        </div>
                    </nav>

                    <div class="ms-1 mb-4 me-2">
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal-printer"><i class="fa fa-plus me-2"></i>プリンターを登録</button>
                        <div class="ms-1 mt-1">
                            <div><small><span class="text-danger">*1</span> Epson Connect 対応プリンターを登録してください</small></div>
                            <div><small><span class="text-danger">*2</span> エプソンプリンターをお持ちで Epson Connect への登録がまだの方は<a href="https://www.epsonconnect.com/guide/ja/html/p01.htm" class="text-tertiary text-decoration-underline" target="_blank" rel="noopener noreferrer">コチラ</a></small></div>
                        </div>
                    </div>

                    @if(\Auth::user()->printers()->isEmpty())
                        <div class="card p-1 p-md-4 mb-4 mb-lg-0 bg-gray-100">
                            <div class="card-body">
                                <div class="icon icon-shape icon-shape-primary rounded-circle mb-4">
                                    <span class="far fa-lightbulb"></span>
                                </div>
                                <h3 class="h5 mb-3">現在、印刷可能なプリンターが登録されていません</h3>
                                <p><code class="px-2 py-1 me-1 d-inline-block bg-gray-300">Epson Connect 対応プリンター</code>を登録していただくと、アルバム収納用フォトのセルフプリントが可能です</p>
                            </div>
                        </div>
                    @else
                        <div>
                            <table class="table responsive-table">
                                <tbody>
                                    <tr>
                                        <th style="text-align:left;">販売業者
                                        </th>
                                        <td style="text-align:left;">COLORBOX株式会社</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">代表責任者
                                        </th>
                                        <td style="text-align:left;">高井昭彦</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">所在地
                                        </th>
                                        <td style="text-align:left;">
                                            〒１５０-０００１<br>
                                            東京都渋谷区神宮前六丁目２３番４号
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">電話番号
                                        </th>
                                        <td style="text-align:left;">090-6124-7916</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">電話受付時間
                                        </th>
                                        <td style="text-align:left;">8:00 - 17:00</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">メールアドレス
                                        </th>
                                        <td style="text-align:left;">info@colorbox.tech</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">サイトURL
                                        </th>
                                        <td style="text-align:left;">https://colorbox.tech</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">販売価格
                                        </th>
                                        <td style="text-align:left;">各商品の紹介ページに記載している価格とします。</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">商品代金以外に必要な料金
                                        </th>
                                        <td style="text-align:left;">
                                            消費税、送料（全国一律３８０円）<br>
                                            ※２，０００円以上購入すれば送料無料、ラッピング代１００円（希望者のみ）
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">引き渡し時期
                                        </th>
                                        <td style="text-align:left;">ご注文から３日以内に発送します。</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">お支払い方法とお支払いの時期
                                        </th>
                                        <td style="text-align:left;">
                                            クレジットカード決済：ご注文時にお支払いが確定します。<br>
                                            代金引換：代金は商品お届け時、配送員に現金でお支払いください。<br>
                                            コンビニ決済：ご注文から３日以内に、コンビニでお支払いください。
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">返品・交換・キャンセルについて
                                        </th>
                                        <td style="text-align:left;">
                                            商品発送後の返品・交換・キャンセルには、基本的に対応しておりません。<br>
                                            商品に欠陥がある場合のみ交換が可能ですのでご連絡ください。
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">返品期限
                                        </th>
                                        <td style="text-align:left;">商品出荷から１０日以内にご連絡ください。</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">返品送料
                                        </th>
                                        <td style="text-align:left;">
                                            商品に欠陥がある場合は、弊社で負担いたします。<br>
                                            それ以外は、お客さまのご負担になります。
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>

                <div class="modal fade" id="modal-printer" tabindex="-1" role="dialog" aria-labelledby="modal-printer" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <form method="POST" action="{{ route('printer.store') }}" class="modal-content">
                            @csrf
                            <div class="modal-header">
                                <h2 class="h6 modal-title">プリンターの登録</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label for="input-name">プリンタ名 (管理用)</label>
                                    <input id="input-name" type="text" class="form-control" name="name" placeholder="自宅プリンター">
                                    <div class="form-text text-gray text-left text-sm"><span class="text-danger">*</span> 50字以内</div>
                                </div>
                                <div class="form-group">
                                    <label for="input-name">プリンターのメールアドレス</label>
                                    <input id="input-name" type="text" class="form-control" name="email" placeholder="xxxxxxxxxxxxxxx@print.epsonconnect.com">
                                    <div class="form-text text-gray text-left text-sm"><span class="text-danger">*</span> Epson Connect 設定で取得したもの</div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-warning text-white">登録</button>
                                <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">キャンセル</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>


</main>
@endsection
