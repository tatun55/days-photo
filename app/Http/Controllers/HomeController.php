<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\ImageSet;
use App\Models\PostedImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $albums = Album::query()
            ->withCount('images')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        return view('home', compact('albums'));
    }

    public function pp()
    {
        return view('pp');
    }

    public function terms()
    {
        return view('terms');
    }
    public function ld()
    {
        return view('ld');
    }
}