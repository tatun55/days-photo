<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\ImageSet;
use App\Models\PostedImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function welcome()
    {
        return view('pages.welcome');
    }
    public function home()
    {
        $albums = Album::query()
            ->withCount('images')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        return view('pages.user.home', compact('albums'));
    }

    public function pp()
    {
        return view('pages.pp');
    }

    public function terms()
    {
        return view('pages.terms');
    }
    public function ld()
    {
        return view('pages.ld');
    }
}