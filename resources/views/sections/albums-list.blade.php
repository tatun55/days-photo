<div class="row">
    <div class="col-12">
        <ul class="list-unstyled news-list">
            @foreach($albums as $album)
                <li class="d-flex mx-0 mb-4 w-100">
                    @switch($type)
                        @case('home')
                            <a href="{{ route('albums.show',$album->id) }}" class="album-thumbnail-link">
                                <div class="img-wrapper-1x1">
                                    <div class="img-content">
                                        <img class="rounded" src="{{ \Storage::disk('s3')->url("/{$album->id}/{$album->cover}/s.jpg") }}">
                                    </div>
                                </div>
                            </a>
                            @break
                        @case('trashbox')
                            <span class="album-thumbnail-link">
                                <div class="img-wrapper-1x1">
                                    <div class="img-content">
                                        <img class="rounded" src="{{ \Storage::disk('s3')->url("/{$album->id}/{$album->cover}/s.jpg") }}">
                                    </div>
                                </div>
                            </span>
                            @break
                    @endswitch
                    <div style="width:100%">
                        <div class="d-flex justify-content-between">
                            @switch($type)
                                @case('home')
                                    <a href="{{ route('albums.show',$album->id) }}" class="h5 m-0 me-2 p-0">{{ $album->title }}</a>
                                    @break
                                @case('trashbox')
                                    <span class="h5 m-0 me-2 p-0">{{ $album->title }}</span>
                                    @break
                            @endswitch

                            <div>
                                <button class="btn btn-link dropdown-toggle dropdown-toggle-split me-2 m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="icon icon-sm"><span class="fas fa-ellipsis-h icon-secondary fa-lg"></span> </span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu">

                                    @switch($type)
                                        @case('home')
                                            @include('sections.dropdown-menus.home')
                                            @break
                                        @case('trashbox')
                                            @include('sections.dropdown-menus.trashbox')
                                            @break
                                    @endswitch

                                </div>
                            </div>
                        </div>

                        <div class="post-meta font-small">
                            <span class="me-3"><span class="far fa-clock me-2"></span>{{ $album->created_at->format('Y-m-d H:i') }}</span>
                            @switch($type)
                                @case('home')
                                    <a href="{{ route('albums.show',$album->id) }}" class="text-secondary"><span class="fa fa-camera me-2"></span>{{ $album->images_count }}</a>
                                    @break
                            @endswitch
                        </div>
                    </div>
                </li>

                @switch($type)
                    @case('home')
                        @include('sections.modals.home')
                        @break
                    @case('trashbox')
                        @include('sections.modals.trashbox')
                        @break
                @endswitch

            @endforeach
        </ul>
    </div>
</div>
