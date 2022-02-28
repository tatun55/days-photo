<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\ImageSet;
use App\Models\PostedImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function show(Album $album)
    {
        return view('pages.albums.show', compact(['album']));
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