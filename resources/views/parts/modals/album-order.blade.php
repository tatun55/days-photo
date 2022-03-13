<div class="modal fade" id="modal-album-{{ $album->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-album-{{ $album->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded">
            <div class="modal-body p-0">
                <div class="card border-gray-300">
                    <button type="button" class="btn-close ms-auto p-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="card-header border-0 bg-white text-center pb-3">
                        <h2 class="h4">部屋に飾れるミニアルバムを作る</h2>
                        <span>このアルバムで管理中のフォト {{ isset($photos) ? $photos->count() : $album->photos_count }} 枚から作成します</span>
                    </div>
                    <form method="POST" action="{{ route('order.store') }}" class="card-body">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ \Auth::user()->id }}">
                        <input type="hidden" name="album_id" value="{{ $album->id }}">
                        <label class="h6">ページ数 <small class="fw-light"><span class="text-danger">*</span>25ページまで</small></label>
                        <p>{{ isset($photos) ? $photos->count() : $album->photos_count }}ページ</p>
                        <label class="h6">タイプを選択</label>
                        <div class="form-group d-block d-sm-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="type1" value="1" checked>
                                <label class="form-check-label" for="type1">
                                    シンプル
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="type2" value="2" disabled>
                                <label class="form-check-label" for="type2">
                                    カジュアル <span class="text-danger">*</span>準備中
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="type3" value="3" disabled>
                                <label class="form-check-label" for="type3">
                                    ミニマル <span class="text-danger">*</span>準備中
                                </label>
                            </div>
                        </div>
                        <div id="Carousel3" class="carousel slide" data-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#Carousel3" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#Carousel3" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#Carousel3" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                <button type="button" data-bs-target="#Carousel3" data-bs-slide-to="3" aria-label="Slide 4"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="{{ asset('img/pet-01-size-m.jpg') }}" alt="First slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="{{ asset('img/pet-02-size-m.jpg') }}" alt="Second slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="{{ asset('img/pet-03-size-m.jpg') }}" alt="Third slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="{{ asset('img/pet-04-size-m.jpg') }}" alt="Fourth slide">
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

                        <label class="h6" style="cursor: pointer;" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="「設定」メニューからプリンターを登録すると、アルバムに収納されるフォトのセルフプリントが可能です。ご注文後に印刷可能となります。">フォト <span class="fa fa-question-circle"></span></label>
                        <div class="container">
                            <div class="form-group row">
                                <div class="form-check col-6">
                                    <input class="form-check-input" type="radio" name="self_print" id="self_print_1" value="0" checked>
                                    <label class="form-check-label" for="self_print_1">
                                        アルバムに同梱
                                    </label>
                                </div>
                                <div class="form-check col-6">
                                    <input class="form-check-input" type="radio" name="self_print" id="self_print_2" value="1" @if(\Auth::user()->printer_id === null) disabled @endif>
                                    <label class="form-check-label" for="self_print_2">
                                        セルフプリント
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
