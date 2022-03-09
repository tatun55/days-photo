<div class="modal fade" id="modal-title" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
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

<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
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

<div class="modal fade" id="modal-album" tabindex="-1" role="dialog" aria-labelledby="modal-album" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded">
            <div class="modal-body p-0">
                <div class="card border-gray-300">
                    <button type="button" class="btn-close ms-auto p-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="card-header border-0 bg-white text-center pb-3">
                        <h2 class="h4">部屋に飾れるミニアルバムを作る</h2>
                        <span>このページで管理中のフォト {{ $album->photos()->count() }} 枚から作成します</span>
                    </div>
                    <form class="card-body">
                        <label class="h6">ページ数 <small class="fw-light"><span class="text-danger">*</span>25ページまで</small></label>
                        <p>{{ $album->photos()->count() }}ページ</p>
                        <label class="h6">タイプを選択</label>
                        <div class="form-group d-block d-sm-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    シンプル
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2" disabled>
                                <label class="form-check-label" for="exampleRadios2">
                                    カジュアル <span class="text-danger">*</span>準備中
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3" disabled>
                                <label class="form-check-label" for="exampleRadios3">
                                    ミニマル <span class="text-danger">*</span>準備中
                                </label>
                            </div>
                        </div>
                        <div id="Carousel3" class="carousel slide" data-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#Carousel3" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#Carousel3" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#Carousel3" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="../../assets/img/carousel/image-1.jpg" alt="First slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="../../assets/img/carousel/image-2.jpg" alt="Second slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="../../assets/img/carousel/image-3.jpg" alt="Third slide">
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-2 mb-4">
                            <button class="btn btn-secondary text-white d-block mx-auto" disabled>完成イメージをみる</button>
                            <small><span class="text-danger">*</span>この機能は準備中です</small>
                        </div>

                        <label class="h6">付属品</label>
                        <ol>
                            <li>メッセージカード</li>
                        </ol>

                        <label class="h6">フォト印刷</label>
                        <div class="container">
                            <div class="form-group row">
                                <div class="form-check col-6">
                                    <input class="form-check-input" type="radio" name="print_type" id="print_type_1" value="1" disabled>
                                    <label class="form-check-label" for="print_type_1">
                                        弊社で印刷
                                    </label>
                                </div>
                                <div class="form-check col-6">
                                    <input class="form-check-input" type="radio" name="print_type" id="print_type_2" value="2" disabled>
                                    <label class="form-check-label" for="print_type_2">
                                        自分で印刷
                                    </label>
                                </div>
                            </div>
                        </div>

                        @if($album->photos()->count() > 25)
                            <div class="text-center">
                                <small class="text-danger">ミニアルバムを作成するには、写真を25枚以下にしてください</small>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 my-4" disabled>カートに入れる</button>
                        @else
                            <button type="submit" class="btn btn-primary w-100 my-4">カートに入れる</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
