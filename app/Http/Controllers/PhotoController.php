<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\ImageFromUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function action(Request $request, Album $album)
    {
        switch (true) {
            case $request->has('action_delete'):
                $album->images()->whereIn('index', $request->items)->delete();
                $this->reIndexing($album);
                return back()->with('status', '写真をアーカイブに移動しました');
            case $request->has('action_destroy'):
                # code...
                break;
            case $request->has('action_move'):
                # code...
                break;
            case $request->has('action_restore'):
                # code...
                break;
        }
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

    public function trashbox(Album $album)
    {
        $items = $album->images()->onlyTrashed()->get(['id', 'index', 'width', 'height'])->keyBy('index');
        return view('pages.album.trash', compact('album', 'items'));
    }
}