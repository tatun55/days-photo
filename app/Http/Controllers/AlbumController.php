<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    public function show(Album $album, Request $request)
    {
        $flagModal = $request->has('modal');
        $photos = $album->photos()
            ->whereHas('users', function ($q) {
                $q->where('user_id', Auth::user()->id)->where('is_archived', false);
            })
            ->orderBy('created_at')
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
            ->orderBy('created_at')
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
}