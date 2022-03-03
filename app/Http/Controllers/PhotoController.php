<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\ImageFromUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function delete(Request $request, Album $album)
    {
        $album->images()->whereIn('index', $request->items)->delete();
        $this->reIndexing($album);
        return back()->with('status', '写真をアーカイブに移動しました');
    }

    private function reIndexing(Album $album)
    {
        $arr = $album->images()->orderBy('index', 'asc')->get()->toArray();
        $newArr = [];
        $now = Carbon::now();
        foreach ($arr as $key => $value) {
            $merged = array_merge($value, ['index' => $key + 1, 'created_at' => $now, 'updated_at' => $now]);
            $newArr[] = $merged;
        }
        ImageFromUser::upsert($newArr, 'id', ['index']);
    }
}