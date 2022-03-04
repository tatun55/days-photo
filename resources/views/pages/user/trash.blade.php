@extends('layouts.app')

@section('content')
<main>
    <div class="section section-lg pt-5 pt-md-6">
        <div class="container">
            <div class="row pt-4 pt-md-0">

                @include('sections.profile-card')

                <div class="col-12 col-lg-8 mt-4 mt-lg-3">

                    {{-- タブメニュー --}}
                    <nav>
                        <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link" href="{{ route('home') }}"><span class="fas fa-images me-1"></span>アルバム</a>
                            <a class="nav-item nav-link active"><span class="fas fa-trash me-1"></span>アーカイブ</a>
                        </div>
                    </nav>

                    @include('sections.albums-list',['type'=>'trashbox'])
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
