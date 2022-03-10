<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    public function show(Album $album)
    {
        $dataSource = $this->getDataSource($album);
        return view('pages.user.album.show', compact(['album', 'dataSource']));
    }

    public function trashbox(Album $album)
    {
        $isTrashed = true;
        $dataSource = $this->getDataSource($album, $isTrashed);
        return view('pages.user.album.trash', compact('album', 'dataSource'));
    }

    private function getDataSource(Album $album, $isTrashed = false)
    {
        $photos = $album->photos();
        $isTrashed && $photos->onlyTrashed();
        $array = $photos->get(['id', 'index', 'width', 'height'])->keyBy('index');
        $path = \Storage::disk('s3')->url($album->id);
        $dataSource = [];
        foreach ($array as $key => $value) {
            $dataSource[] = [
                'srcset' => "{$path}/{$value->id}/l.jpg 1920w, {$path}/{$value->id}/m.jpg 960w",
                'src' => "{$path}/{$value->id}/l.jpg",
                'w' => $value->width,
                'h' => $value->height,
            ];
        }
        return $dataSource;
    }

    public function title(Request $request, Album $album)
    {
        $album->title = $request->title;
        $album->save();
        return back()->with('status', 'タイトルを変更しました');
    }

    public function archive(Album $album)
    {
        $album->users()->syncWithoutDetaching([Auth::user()->id => ['is_archived' => true]]);
        return redirect('home')->with('status', 'アルバムをアーカイブに移動しました');
    }

    public function detach(Album $album)
    {
        $album->users()->detach(Auth::user()->id);
        return redirect('home')->with('status', 'アルバムを完全に削除しました');
    }

    public function restore(Album $album)
    {
        $album->users()->syncWithoutDetaching([Auth::user()->id => ['is_archived' => false]]);
        return redirect('home')->with('status', 'アルバムを元に戻しました');
    }
}