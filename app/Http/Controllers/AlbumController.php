<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\ImageFromUser;
use App\Models\ImageSet;
use App\Models\PostedImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function show(Album $album)
    {
        $items = $album->images()->get(['id', 'index', 'width', 'height'])->keyBy('index');
        return view('pages.albums.show', compact(['album', 'items']));
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

    public function photosDelete(Request $request, Album $album)
    {
        // dd($request->items);
        $album->images()->whereIn('index', $request->items)->delete();
        $this->reIndexing($album);
        return back()->with('status', '写真をアーカイブに移動しました');
    }

    private function reIndexing(Album $album)
    {
        $arr = $album->images()->orderBy('index', 'asc')->get()->toArray();
        $newArr = [];
        $now = \Carbon\Carbon::now();
        foreach ($arr as $key => $value) {
            $merged = array_merge($value, ['index' => $key + 1, 'created_at' => $now, 'updated_at' => $now]);
            $newArr[] = $merged;
        }
        ImageFromUser::upsert($newArr, 'id', ['index']);
    }
}