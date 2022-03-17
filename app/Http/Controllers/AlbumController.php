<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumUser;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    public function store(Request $request)
    {
        dd($request->file('files'));
    }

    public function show(Album $album, Request $request)
    {
        $flagModal = $request->has('modal'); // from line quick reply button
        $photos = $album->photos()
            ->whereHas('users', function ($q) {
                $q->where('user_id', Auth::user()->id)->where('is_archived', false);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        $dataSource = $this->getDataSource($album->id, $photos);
        return view('pages.user.album.show', compact(['album', 'photos', 'dataSource', 'flagModal']));
    }

    public function trashbox(Album $album)
    {
        $photos = $album->photos()
            ->whereHas('users', function ($q) {
                return $q->where('user_id', Auth::user()->id)->where('is_archived', true);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        $dataSource = $this->getDataSource($album->id, $photos);
        return view('pages.user.album.trash', compact('album', 'photos', 'dataSource'));
    }

    private function getDataSource($albumId, $photos)
    {
        $path = \Storage::disk('s3')->url($albumId);
        $dataSource = [];
        foreach ($photos as $key => $value) {
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

    public function autoSaving(Album $album, Request $request)
    {
        if ($request->save === "0") {
            Group::find($album->group_id)->users()->updateExistingPivot(Auth::user()->id, [
                'auto_saving' => false,
            ]);
        } else {
            Group::find($album->group_id)->users()->updateExistingPivot(Auth::user()->id, [
                'auto_saving' => true,
            ]);
        };

        return redirect('home')->with('status', '保存設定を変更しました');
    }
}