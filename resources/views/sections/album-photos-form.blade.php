<form id="items-form" action="{{ route('albums.photos.action',$album->id) }}" method="post">
    @csrf
    @method('put')
    <div id="item-menus" class="d-flex p-3 position-sticky bg-white" style="z-index: 999;top:0">
        <div id="left-btns" class="d-flex justify-content-start w-100">
            <div id="select-desc" class="form-control-plaintext w-auto mx-2 hide"><span class="fas fa-info-circle me-1"></span>写真を選択してください</div>
            @switch($type)
                @case('show')
                    @include('sections.action-menu-btns.show')
                    @break
                @case('trashbox')
                    @include('sections.action-menu-btns.trashbox')
                    @break
            @endswitch
        </div>
        <div id="cancel-btn" class="btn btn-outline-primary w-auto flex-shrink-0 hide">キャンセル</div>
        <div id="select-btn" class="btn btn-primary flex-shrink-0 hide show">選択</div>
    </div>

    <div class="row">
        <div class="col-12">
            <ul id="photo-list" class="list-unstyled news-list d-flex flex-wrap justify-content-between">
                @foreach($album->images()->when($type === 'trashbox', function($query) {return $query->onlyTrashed();})->orderBy('index','asc')->get() as $image)
                    <li class="item">
                        <div class="img-wrapper-1x1">
                            <label class="img-content">
                                <input name="items[]" type="checkbox" value="{{ $image->index }}" class="hidden-checkbox" disabled><span></span>
                                <img data-index="{{ $image->index }}" src="{{ \Storage::disk('s3')->url("/s/{$image->id}.jpg") }}">
                            </label>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</form>
