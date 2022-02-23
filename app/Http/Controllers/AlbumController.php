<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\ImageSet;
use App\Models\PostedImage;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function show(Album $album)
    {
        return view('pages.albums.show', compact('album'));
    }

    public function pp()
    {
        return view('pp');
    }

    public function terms()
    {
        return view('terms');
    }
}