<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Models\ContactMessage;

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

    public function contact()
    {
        return view('pages.contact');
    }

    public function storeMessage(MessageRequest $request)
    {
        ContactMessage::create($request->validated());
        return back()->with('contact_completed', true);
    }
}