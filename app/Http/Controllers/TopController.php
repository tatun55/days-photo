<?php

namespace App\Http\Controllers;

class TopController extends Controller
{
    public function welcome()
    {
        return view('pages.welcome');
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

    public function about()
    {
        return view('pages.about');
    }
}