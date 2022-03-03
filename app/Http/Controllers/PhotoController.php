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
                $this->delete($request, $album);
                return back()->with('status', '写真をアーカイブに移動しました');
            case $request->has('action_destroy'):
                $album->images()->onlyTrashed()->whereIn('index', $request->items)->forceDelete();
                return back()->with('status', '写真を削除しました');
            case $request->has('action_move'):
                return 'move';
            case $request->has('action_restore'):
                $this->restore($request, $album);
                return back()->with('status', '写真を元に戻しました');
        }
    }

    private function delete(Request $request, Album $album)
    {
        $arrayToDelete = [];
        $arrayNotToDelete = [];

        $countNotToDelete = 0;
        $countToDelete = 0;
        $count = 0;

        $now = Carbon::now()->toDateTimeString();

        // Generate $arrayToDelete
        $count = $album->images()->onlyTrashed()->count();
        $imagesToDelete = $album->images()->orderBy('index', 'asc')->whereIn('index', $request->items)->get()->toArray();
        foreach ($imagesToDelete as $key => $value) {
            $merged = array_merge($value, [
                'index' => $key + 1 + $count,
                'deleted_at' => $now,
                'created_at' => Carbon::create($value["created_at"])->toDateTimeString(),
                'updated_at' => Carbon::create($value["updated_at"])->toDateTimeString(),
            ]);
            $arrayToDelete[] = $merged;
        }

        // Generate $arrayNotToDelete
        $imagesNotToDelete = $album->images()->orderBy('index', 'asc')->whereNotIn('index', $request->items)->get()->toArray();
        foreach ($imagesNotToDelete as $key => $value) {
            $merged = array_merge($value, [
                'index' => $key + 1,
                'deleted_at' => null,
                'created_at' => Carbon::create($value["created_at"])->toDateTimeString(),
                'updated_at' => Carbon::create($value["updated_at"])->toDateTimeString(),
            ]);
            $arrayNotToDelete[] = $merged;
        }

        $arrayMerged = array_merge($arrayToDelete, $arrayNotToDelete);

        ImageFromUser::upsert($arrayMerged, 'id', ['index', 'deleted_at']);
    }

    private function restore(Request $request, Album $album)
    {
        $arrayToRestore = [];
        $arrayNotToRestore = [];

        $countNotToRestore = 0;
        $countToRestore = 0;
        $count = 0;

        $now = Carbon::now()->toDateTimeString();

        // Generate $arrayToRestore
        $count = $album->images()->count();
        $imagesToRestore = $album->images()->onlyTrashed()->orderBy('deleted_at', 'desc')->whereIn('index', $request->items)->get()->toArray();
        foreach ($imagesToRestore as $key => $value) {
            $merged = array_merge($value, [
                'index' => $key + 1 + $count,
                'deleted_at' => null,
                'created_at' => Carbon::create($value["created_at"])->toDateTimeString(),
                'updated_at' => Carbon::create($value["updated_at"])->toDateTimeString(),
            ]);
            $arrayToRestore[] = $merged;
        }

        // Generate $arrayNotToRestore
        $imagesNotToRestore = $album->images()->onlyTrashed()->orderBy('deleted_at', 'desc')->whereNotIn('index', $request->items)->get()->toArray();
        foreach ($imagesNotToRestore as $key => $value) {
            $merged = array_merge($value, [
                'index' => $key + 1,
                'deleted_at' => Carbon::create($value["created_at"])->toDateTimeString(),
                'created_at' => Carbon::create($value["created_at"])->toDateTimeString(),
                'updated_at' => Carbon::create($value["updated_at"])->toDateTimeString(),
            ]);
            $arrayNotToRestore[] = $merged;
        }

        $arrayMerged = array_merge($arrayToRestore, $arrayNotToRestore);

        ImageFromUser::upsert($arrayMerged, 'id', ['index', 'deleted_at']);
    }

    public function trashbox(Album $album)
    {
        $items = $album->images()->onlyTrashed()->get(['id', 'index', 'width', 'height'])->keyBy('index');
        return view('pages.album.trash', compact('album', 'items'));
    }
}