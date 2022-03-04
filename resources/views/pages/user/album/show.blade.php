@extends('layouts.app',['photoSwipe' => true])

@section('content')
<main>
    <section id="album" class="section section-lg pt-5 pt-md-6">
        <div class="container">
            <div class="row pt-4 pt-md-0">

                <!--Breadcrumb-->
                <nav class="ms-2 mb-0 mt-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><span class="fas fa-home"></span></span> ホーム</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $album->title }}</li>
                    </ol>
                </nav>
                <!--End of Breadcrumb-->

                @include('sections.album-card-top')

                <div class="col-12 col-lg-8 mt-4 mt-lg-3">

                    {{-- Tab Menu --}}
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active"><span class="fas fa-images me-1"></span>フォト</a>
                            <a href="{{ route('albums.photos.trashbox',$album->id) }}" class="nav-item nav-link"><span class="fas fa-trash me-1"></span>アーカイブ</a>
                        </div>
                    </nav>
                    {{-- End of Tab Menu --}}

                    @include('sections.album-photos-form')

                </div>
            </div>

            <div class="modal fade" id="modal-title-{{ $album->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <form method="POST" action="{{ route('albums.title',$album->id) }}" class="modal-content">
                        @csrf
                        @method('put')
                        <div class="modal-header">
                            <h2 class="h6 modal-title">アルバムのタイトルを入力</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" class="form-control" name="title" value="{{ $album->title }}">
                            <div class="form-text text-gray text-right text-sm">50字以内</div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary text-white">変更</button>
                            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">キャンセル</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal fade" id="modal-delete-{{ $album->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <form method="POST" action="{{ route('albums.delete',$album->id) }}" class="modal-content">
                        @csrf
                        @method('delete')
                        <div class="modal-header">
                            <h2 class="h6 modal-title">アーカイブへ移動しますか？</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning text-white">アーカイブへ移動</button>
                            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">キャンセル</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        </div>
</main>
@endsection
