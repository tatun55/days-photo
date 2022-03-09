<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        Order::create($request->all());
        return redirect('cart')->with('status', 'カートに追加されました');
    }

    public function cart()
    {
        $orders = Order::where('user_id', Auth::user()->id)->where('status', 'default')->orderBy('created_at', 'desc')->get();
        return view('pages.user.cart', compact('orders'));
    }
}