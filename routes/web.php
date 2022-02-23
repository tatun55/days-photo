<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('intro');

Route::get('login/line', [LoginController::class, 'redirectToProvider'])->name('login');
Route::get('login/line/callback', [LoginController::class, 'handleProviderCallback']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('home', [HomeController::class, 'home'])->name('home');
    Route::get('albums/{album}', [AlbumController::class, 'show'])->name('albums.show');
    Route::put('albums/{album}/title', [AlbumController::class, 'title'])->name('albums.title');
});

Route::get('pp', [HomeController::class, 'pp'])->name('pp');
Route::get('terms', [HomeController::class, 'terms'])->name('terms');

Route::get('image-editor-{ver}', function ($ver) {
    return view("image-editors.{$ver}");
});