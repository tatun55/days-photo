<?php

namespace App\Http\Controllers;

use App\Models\Printer;
use Illuminate\Http\Request;

class PriterController extends Controller
{
    public function store(Request $request)
    {
        $printer = new Printer();
        $printer->name = $request->name;
        $printer->email = $request->email;
        $printer->available = true;
        $printer->save();

        return back()->with('status', 'プリンターが登録されました');
    }
}