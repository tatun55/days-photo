<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhotoController extends Controller
{
    public function action(Request $request, Album $album)
    {
        switch (true) {
            case $request->has('action_delete'):
                Auth::user()->photos()->updateExistingPivot($request->photo_ids, ['is_archived' => true]);
                return back()->with('status', '写真をアーカイブに移動しました');
            case $request->has('action_restore'):
                Auth::user()->photos()->updateExistingPivot($request->photo_ids, ['is_archived' => false]);
                return back()->with('status', '写真を元に戻しました');
            case $request->has('action_destroy'):
                Auth::user()->photos()->detach($request->photo_ids);
                return back()->with('status', '写真を削除にしました');
            case $request->has('action_move'):
                // TODO: implement
                return 'move';
        }
    }

    private function destroy(Request $request, Album $album)
    {
        $album->photos()->onlyTrashed()->whereIn('index', $request->items)->forceDelete();
        $images = $album->photos()->onlyTrashed()->orderBy('index', 'asc')->get();
        if (!$images->isEmpty()) {
            $this->reIndexing($images->toArray());
        }
    }

    private function reIndexing($images)
    {
        $arrayToReIndexing = [];
        foreach ($images as $key => $value) {
            $merged = array_merge($value, [
                'index' => $key + 1,
                'deleted_at' => Carbon::create($value["deleted_at"])->toDateTimeString(),
                'created_at' => Carbon::create($value["created_at"])->toDateTimeString(),
                'updated_at' => Carbon::create($value["updated_at"])->toDateTimeString(),
            ]);
            $arrayToReIndexing[] = $merged;
        }
        Photo::upsert($arrayToReIndexing, 'id', ['index']);
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
        $count = $album->photos()->onlyTrashed()->count();
        $imagesToDelete = $album->photos()->orderBy('index', 'asc')->whereIn('index', $request->items)->get()->toArray();
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
        $imagesNotToDelete = $album->photos()->orderBy('index', 'asc')->whereNotIn('index', $request->items)->get()->toArray();
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

        Photo::upsert($arrayMerged, 'id', ['index', 'deleted_at']);
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
        $count = $album->photos()->count();
        $imagesToRestore = $album->photos()->onlyTrashed()->orderBy('deleted_at', 'desc')->whereIn('index', $request->items)->get()->toArray();
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
        $imagesNotToRestore = $album->photos()->onlyTrashed()->orderBy('deleted_at', 'desc')->whereNotIn('index', $request->items)->get()->toArray();
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

        Photo::upsert($arrayMerged, 'id', ['index', 'deleted_at']);
    }
}