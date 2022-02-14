<?php

namespace App\Http\Controllers;

use App\Models\PostedImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        // $postedImages = PostedImage::orderBy('created_at', 'desc')->limit(10)->get();
        // return view('home', compact('postedImages'));
        // $postedImages = PostedImage::orderBy('created_at', 'desc')->limit(10)->get();
        return view('home');
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