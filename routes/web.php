<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TrashController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('intro');

Route::get('login/line', [LoginController::class, 'redirectToProvider'])->name('login');
Route::get('login/line/callback', [LoginController::class, 'handleProviderCallback']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('home', [HomeController::class, 'home'])->name('home');

    Route::post('albums/{album}/restore', [AlbumController::class, 'restore'])->withTrashed()->name('albums.restore');
    Route::get('albums/{album}', [AlbumController::class, 'show'])->name('albums.show');
    Route::delete('albums/{album}', [AlbumController::class, 'delete'])->name('albums.delete');
    Route::delete('albums/{album}/force', [AlbumController::class, 'forceDelete'])->withTrashed()->name('albums.delete.force');
    Route::put('albums/{album}/title', [AlbumController::class, 'title'])->name('albums.title');

    Route::get('trashbox', [TrashController::class, 'index'])->name('trashbox');
});

Route::get('pp', [HomeController::class, 'pp'])->name('pp');
Route::get('terms', [HomeController::class, 'terms'])->name('terms');
Route::get('ld', [HomeController::class, 'ld'])->name('ld');

Route::get('photoswipe/test', function () {
    return view('photoswipe.test');
});