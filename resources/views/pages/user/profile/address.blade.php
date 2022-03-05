@extends('layouts.app')

@section('content')
<main>
    <div class="section">
        <div class="container">
            <div class="row">

                <!--Breadcrumb-->
                <nav class="ms-2 mb-0 mt-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fas fa-home me-1"></span></span>ホーム</a></li>
                        <li class="breadcrumb-item active" aria-current="page">アカウントサービス</li>
                    </ol>
                </nav>
                <!--End of Breadcrumb-->

                @include('sections.profile-card')

                <div class="col-12 col-lg-8 mt-4 mt-lg-3">

                    <nav>
                        <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active"><span class="fas fa-images me-1"></span>お届け先</a>
                        </div>
                    </nav>

                    <button class="btn ms-1 mb-4 me-2 btn-primary" type="button"><i class="fa fa-plus me-2"></i>お届け先を追加</button>

                    <div class="card p-1 p-md-4 mb-4 mb-lg-0 bg-gray-100">
                        <div class="card-body">
                            <div class="icon icon-shape icon-shape-primary rounded-circle mb-4">
                                <span class="far fa-lightbulb"></span>
                            </div>
                            <h3 class="h5 mb-3">現在、お届け先がありません</h3>
                            <p>お届け先を登録しておくと、部屋にかざれるミニアルバムをワンクリックで、スムーズに発送できます。</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


</main>
@endsection
