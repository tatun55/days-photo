<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrashController extends Controller
{
    public function index(Album $album)
    {
        $trashedAlbums = Album::where('line_user_id', Auth::user()->id)->orderBy('deleted_at', 'desc')->onlyTrashed()->withCount('images')->get();
        return view('pages.trashes.index', compact('trashedAlbums'));
    }
}