<?php

namespace App\Http\Controllers;

use App\Models\Printer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PriterController extends Controller
{
    public function store(Request $request)
    {
        $printer = new Printer();
        $printer->user_id = Auth::user()->id;
        $printer->name = $request->name;
        $printer->email = $request->email;
        $printer->save();

        if (Auth::user()->printer_id === null) {
            Auth::user()->update(['printer_id' => $printer->id]);
        }

        return back()->with('status', 'プリンターが登録されました');
    }
}