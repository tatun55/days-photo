<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function show(Album $album)
    {
        $items = $album->images()->get(['id', 'index', 'width', 'height'])->keyBy('index');
        return view('pages.album.show', compact(['album', 'items']));
    }

    public function title(Request $request, Album $album)
    {
        $album->title = $request->title;
        $album->save();
        return back()->with('status', 'タイトルを変更しました');
    }

    public function delete(Album $album)
    {
        $album->delete();
        return redirect('home')->with('status', 'アルバムをアーカイブに移動しました');
    }

    public function forceDelete(Album $album)
    {
        $album->forceDelete();
        return redirect('home')->with('status', 'アルバムを完全に削除しました');
    }

    public function restore(Album $album)
    {
        $album->restore();
        return redirect('home')->with('status', 'アルバムを元に戻しました');
    }
}
