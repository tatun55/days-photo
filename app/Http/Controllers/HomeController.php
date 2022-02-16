<?php

namespace App\Http\Controllers;

use App\Models\ImageSet;
use App\Models\PostedImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $imageSetList = ImageSet::query()
            ->withCount('images')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        return view('home', compact('imageSetList'));
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