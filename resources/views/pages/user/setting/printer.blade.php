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
                        <button class="btn btn-primary" type="button"><i class="fa fa-plus me-2"></i>プリンターを登録</button>
                        <div><small><span class="text-danger">*1</span> Epson Connect 対応プリンターを登録してください</small></div>
                        <div><small><span class="text-danger">*2</span> エプソンプリンターをお持ちで Epson Connect への登録がまだの方は<a href="https://www.epsonconnect.com/guide/ja/html/p01.htm" class="text-tertiary text-decoration-underline" target="_blank" rel="noopener noreferrer">コチラ</a></small></div>
                    </div>

                    <div class="card p-1 p-md-4 mb-4 mb-lg-0 bg-gray-100">
                        <div class="card-body">
                            <div class="icon icon-shape icon-shape-primary rounded-circle mb-4">
                                <span class="far fa-lightbulb"></span>
                            </div>
                            <h3 class="h5 mb-3">現在、印刷可能なプリンターが登録されていません</h3>
                            <p><code class="px-2 py-1 me-1 d-inline-block bg-gray-300">Epson Connect 対応プリンター</code>を登録していただくと、アルバム収納用写真のセルフプリントが可能です</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


</main>
@endsection
