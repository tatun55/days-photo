@extends('layouts.app')

@section('content')
<main>
    <div class="section">
        <div class="container">
            <div class="row pt-4 pt-md-0">
                <h4 class="my-4 ms-1">ご注文手続き</h4>


                <!-- Blog Entries Column -->
                <div class="col-md-8">
                    <!-- Blog Post -->
                    <div class="card mb-4" id="highlight1" data-toggle="tooltip1" data-container="body" data-placement="left" data-html="true" title="" data-original-title="&lt;p&gt;このように、Amazon Payを導入したECサイトでは、Amazonアカウントに登録された住所とクレジットカード情報が表示されます。&lt;/p&gt;&lt;p&gt;このため、新たに配送先やクレジットカード情報を入力する必要がないため、簡単・安全にお買い物いただけます。&lt;/p&gt;">

                        <div class="card-body">

                            <h5>お届け先：</h5>

                            <table style="font-size: 16px;" class="table">
                                <tr>
                                    <td>お名前:</td>
                                    <td>
                                        <div id="addressName"></div>
                                    </td>
                                </tr>
                                <!--<tr>-->
                                <!--    <td>メールアドレス:</td><td><div id="buyerEmail"></div></td>-->
                                <!--</tr>-->
                                <tr>
                                    <td>郵便番号:</td>
                                    <td>
                                        <div id="addressZipcode"></div>
                                    </td>
                                </tr>
                                <!--<tr>-->
                                <!--    <td>都道府県:</td><td></td>-->
                                <!--</tr>-->
                                <tr>
                                    <td>住所:</td>
                                    <td>
                                        <div id="addressStageOfRegion"></div>
                                        <div id="addressLine1"></div>
                                        <div id="addressLine2"></div>
                                        <div id="addressLine3"></div>
                                    </td>
                                </tr>
                                <!--<tr>-->
                                <!--    <td>住所２:</td><td><div id="addressLine2"></div></td>-->
                                <!--</tr>-->
                                <!--<tr>-->
                                <!--    <td>住所３:</td><td><div id="addressLine3"></div></td>-->
                                <!--</tr>    -->
                                <tr>
                                    <td>電話番号:</td>
                                    <td>
                                        <div id="phoneNumber"></div>
                                    </td>
                                </tr>


                            </table>
                            <button id="updateCheckoutDetails2" class="btn btn-gray-200 float-end" type="button">お届け先修正</button>
                            <br><br>
                            <!--<hr>-->
                            <!--<h5>支払い方法：<div class="text-center"><img src="./css/logo-pay.png" height=25px align="top">&nbsp;&nbsp;Amazon Pay</div>-->
                            <!--<h5>お支払い方法：<div  style="font-size: 16px;" class="text-center m-3"><img src="./css/logo-pay.png" width=30px align="top">&nbsp;&nbsp;<span id="paymentDescriptor"></span></div>-->

                            <!--<button id="updateCheckoutDetails" class="btn btn-gray-200 float-end" type="button">支払い方法修正</button>-->
                        </div>
                    </div>



                    <div class="card mb-4">
                        <div class="card-body">

                            <!--<h5>請求者情報：</h5>-->

                            <h5>
                                <a class="btn btn-outline-gray-600" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    ▼ ご請求先情報
                                </a>
                            </h5>
                            <div class="collapse" id="collapseExample">
                                <form class="mb-4">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputCity">お名前</label>
                                            <input type="text" class="form-control" id="addressName02">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="mail">メールアドレス</label>
                                            <!--<input type="text" readonly class="form-control-plaintex" id="buyerEmail">-->
                                            <label class="form-control" id="buyerEmail"></label>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputZip">郵便番号</label>
                                            <input type="text" class="form-control" id="ba-addressZipcode">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputState">電話番号</label>
                                            <input type="text" class="form-control" id="ba-phoneNumber">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="inputZip">住所</label>
                                            <input type="text" class="form-control" id="ba-addressStageOfRegion">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputZip">&nbsp;</label>
                                            <input type="text" class="form-control" id="ba-addressLine1">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputZip">&nbsp;</label>
                                            <input type="text" class="form-control" id="ba-addressLine2">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputZip">&nbsp;</label>
                                            <input type="text" class="form-control" id="ba-addressLine3">
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <form class="mb-4">
                                <div class="form-group">
                                    <label for="inputAddress">お支払い方法</label><br>
                                    <img src="{{ asset('img/logo-pay.png') }}" width=30px align="top">&nbsp;&nbsp;
                                    <label type="text" readonly class="form-control-plaintex" id="paymentDescriptor">
                                </div>

                                <button id="updateCheckoutDetails" class="btn btn-gray-200 float-end" type="button">お支払い方法修正</button>

                                <!--<h5>お支払い方法-->

                                <!--<div  style="font-size: 16px;" class="text-center m-3"><img src="./css/logo-pay.png" width=30px align="top">&nbsp;&nbsp;<span id="paymentDescriptor"></span></div>-->
                                <!--<button id="updateCheckoutDetails" class="btn btn-gray-200 float-end" type="button">お支払い方法修正</button>-->
                            </form>
                        </div>
                    </div>


                    <!--<div class="card mb-4">-->
                    <!--  <div class="card-body">-->
                    <!--    <h5 class="card-title">配送方法</h5>-->
                    <!--    <p>指定なし</p>-->
                    <!--    <button class="btn btn-gray-200 float-end">変更</button>-->
                    <!--  </div>-->
                    <!--</div>-->



                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">ご注文内容</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col"> </th>
                                        <th scope="col">商品名</th>
                                        <th scope="col">単価(税込)</th>
                                        <th scope="col" class="text-center">数量</th>
                                        <th scope="col" class="text-right">小計</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><img class="confirmation-item" src="./02_files/sample1.jpg"></td>
                                        <td>コロンビア・ビルバオ コーヒー豆</td>
                                        <td class="text-right">￥2,000</td>
                                        <td class="text-right">1</td>
                                        <td class="text-right">￥2,000</td>
                                    </tr>
                                    <tr>
                                        <td><img class="confirmation-item" src="./02_files/sample2.jpg"></td>
                                        <td>コーヒーカップ</td>
                                        <td class="text-right">￥500</td>
                                        <td class="text-right">1</td>
                                        <td class="text-right">￥500</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <!-- Sidebar Widgets Column -->
                <div class="col-md-4">

                    <!-- Side Widget -->
                    <div class="card mb-4">
                        <div class="card-body" id="highlight2">
                            <h5>お支払い金額</h5>

                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>商品合計</td>
                                        <td class="text-right">￥2,500</td>
                                    </tr>
                                    <tr>
                                        <td>送料</td>
                                        <td class="text-right">￥500</td>
                                    </tr>
                                    <tr>
                                        <td><strong>総合計</strong></td>
                                        <td class="text-right"><strong>￥3,000</strong></td>
                                    </tr>
                                </tbody>
                            </table>

                            {{-- <div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" checked=""></input>
                                        <a href="" onclick="return confirm('利用規約を表示')">利用規約</a>
                                        および
                                        <a href="" onclick="return confirm('プライバシーポリシーを表示')">プライバシーポリシー</a>
                                        に同意の上、会員登録する
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" checked=""> メールマガジンを購読する
                                    </label>
                                </div>
                            </div> --}}

                            <div>
                                <!--<p class="mb005"><button id="placeorder" class="ap_button btn btn01-tumi" type="button">注文する</button></p>-->
                                <button id="placeorder" class="btn btn-primary" data-toggle="tooltip3" data-container="body" data-placement="left" data-html="true" title="" data-original-title="&lt;p&gt;これで注文完了です。&lt;/p&gt;&lt;p&gt;&lt;strong&gt;Amazon Payが実現する簡単・安心な決済&lt;/strong&gt;はいかがでしたでしょうか？&lt;/p&gt;&lt;p&gt;こちらをクリックして、デモサイトでのお買い物を完了しましょう。&lt;/p&gt;&lt;p id=&#39;text-underline&#39;&gt;※デモサイトのため、実際には注文されません。&lt;/p&gt;" aria-describedby="tooltip922528" type="button">購入する</button>
                            </div>

                            <br>

                            <div>
                                <label>
                                    <p>※デモサイトです</p>
                                    <p>※会員登録・課金はされません</p>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">配送方法</h5>
                            <p>指定なし</p>
                            <button class="btn btn-gray-200 float-end">変更</button>
                        </div>
                    </div>


                </div>

            </div>

        </div>

    </div>
</main>
@endsection
