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

                <div class="col-12 col-lg-8 mt-4 mt-lg-0">

                    {{-- Tab Menu --}}
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active"><span class="fas fa-images me-1"></span>フォト</a>
                            <a href="{{ route('albums.trashbox',$album->id) }}" class="nav-item nav-link"><span class="fas fa-trash me-1"></span>アーカイブ</a>
                        </div>
                    </nav>
                    {{-- End of Tab Menu --}}

                    @include('sections.album-photos-form',['type'=>'show'])

                </div>
            </div>
        </div>
    </section>
    @include('sections.modals.albums.show')
</main>
@endsection
