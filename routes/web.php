<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\TopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TopController::class, 'welcome'])->name('welcome');
Route::get('pp', [TopController::class, 'pp'])->name('pp');
Route::get('terms', [TopController::class, 'terms'])->name('terms');
Route::get('ld', [TopController::class, 'ld'])->name('ld');

Route::get('login/line', [LoginController::class, 'redirectToProvider'])->name('login');
Route::get('login/line/callback', [LoginController::class, 'handleProviderCallback']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('home', [HomeController::class, 'home'])->name('home');
    Route::get('trashbox', [HomeController::class, 'trashbox'])->name('trashbox');

    Route::post('albums/{album}/restore', [AlbumController::class, 'restore'])->withTrashed()->name('albums.restore');
    Route::get('albums/{album}', [AlbumController::class, 'show'])->name('albums.show');
    Route::delete('albums/{album}', [AlbumController::class, 'delete'])->name('albums.delete');
    Route::delete('albums/{album}/force', [AlbumController::class, 'forceDelete'])->withTrashed()->name('albums.delete.force');
    Route::put('albums/{album}/title', [AlbumController::class, 'title'])->name('albums.title');

    Route::put('albums/{album}/photos', [PhotoController::class, 'action'])->name('albums.photos.action');
    Route::get('albums/{album}/trashbox', [PhotoController::class, 'trashbox'])->name('albums.photos.trashbox');
});
