<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function home()
    {
        $albums = Album::query()
            ->where('user_id', Auth::user()->id)
            ->withCount('images')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pages.user.home', compact('albums'));
    }

    public function trashbox(Album $album)
    {
        $albums = Album::where('user_id', Auth::user()->id)->orderBy('deleted_at', 'desc')->onlyTrashed()->withCount('images')->get();
        return view('pages.user.trash', compact('albums'));
    }

    public function profile()
    {
        return view('pages.user.profile.address');
    }
}
