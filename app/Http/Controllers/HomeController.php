<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
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