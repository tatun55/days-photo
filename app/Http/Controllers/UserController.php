<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function home()
    {
        $albums = Auth::user()
            ->albums()
            ->where('is_archived', false)
            ->withCount('photos')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pages.user.home', compact('albums'));
    }

    public function trashbox(Album $album)
    {
        $albums = Auth::user()
            ->albums()
            ->where('is_archived', true)
            ->withCount('photos')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pages.user.trash', compact('albums'));
    }

    public function account()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('pages.user.account.history', compact('orders'));
    }
}