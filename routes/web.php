<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('intro');

Route::get('login/{provider}', [LoginController::class, 'redirectToProvider'])->name('login');
Route::get('login/{provider}/callback', [LoginController::class, 'handleProviderCallback']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Route::middleware(['auth'])->group(function () {
//     Route::get('home', 'HomeController@index')->name('home');
// });

Route::get('home', [HomeController::class, 'home'])->name('home');
Route::get('pp', [HomeController::class, 'pp'])->name('pp');
Route::get('terms', [HomeController::class, 'terms'])->name('terms');