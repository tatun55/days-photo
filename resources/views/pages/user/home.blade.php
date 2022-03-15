@extends('layouts.app')

@section('content')
<main>
    <div class="section section-lg pt-5 pt-md-6">
        <div class="container">
            <div class="row pt-4 pt-md-0">
                <div class="mx-2"><small><span class="text-danger">*</span> 現在のバージョンは、α版です ( <a class="text-gray-600 text-decoration-underline" href="https://days-photo.s3.ap-northeast-1.amazonaws.com/days.+%E3%80%9C%E3%81%8B%E3%82%93%E3%81%9F%E3%82%93%E3%83%95%E3%82%A9%E3%83%88%E7%AE%A1%E7%90%86%E3%80%9C+%CE%B1%E7%89%88%E4%BD%BF%E3%81%84%E6%96%B9.pdf" target="_blank" rel="noopener noreferrer">詳しい使い方をPDFでみる</a>)</small></div>
                <div class="mx-2"><small><span class="text-danger">*</span> ぜひご利用後にアンケート回答をお願いします ( <a class="text-gray-600 text-decoration-underline" href="https://forms.gle/AeQLv4qGNQkbNfDy9" target="_blank" rel="noopener noreferrer">アンケートに回答</a>)</small></div>

                @include('sections.profile-card')

                <div class="col-12 col-lg-8 mt-4 mt-lg-3">
                    <nav>
                        <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active"><span class="fas fa-images me-1"></span>アルバム</a>
                            <a href="{{ route('trashbox') }}" class="nav-item nav-link"><span class="fas fa-trash me-1"></span>アーカイブ</a>
                        </div>
                    </nav>
                    {{-- <button class="btn btn-outline-gray-800 mb-4 ms-2" data-bs-toggle="modal" data-bs-target="#modal-post-album">💎 ずっと残るアルバム作成</button> --}}

                    @include('sections.albums-list',['type'=>'home'])
                </div>

            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
