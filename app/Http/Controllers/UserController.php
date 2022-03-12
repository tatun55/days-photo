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
        $userId = Auth::user()->id;
        $albums = Auth::user()
            ->albums()
            ->where('is_archived', false)
            ->withCount(['photos' => function ($query) use ($userId) {
                $query->whereHas('users', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('is_archived', false);
                });
            }])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pages.user.home', compact('albums'));
    }

    public function trashbox(Album $album)
    {
        $userId = Auth::user()->id;
        $albums = Auth::user()
            ->albums()
            ->where('is_archived', true)
            ->withCount(['photos' => function ($query) use ($userId) {
                $query->whereHas('users', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('is_archived', false);
                });
            }])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pages.user.trash', compact('albums'));
    }

    public function account()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('pages.user.account.history', compact('orders'));
    }

    public function setting()
    {
        $printers = Auth::user()->printers()->get();
        return view('pages.user.setting.printer', compact('printers'));
    }
}