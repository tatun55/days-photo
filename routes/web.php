<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AmazonPayController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PriterController;
use App\Http\Controllers\TopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [TopController::class, 'welcome'])->name('welcome');
Route::get('pp', [TopController::class, 'pp'])->name('pp');
Route::get('terms', [TopController::class, 'terms'])->name('terms');
Route::get('ld', [TopController::class, 'ld'])->name('ld');
Route::get('about', [TopController::class, 'about'])->name('about');

Route::get('login/line', [LoginController::class, 'redirectToProvider'])->name('login');
Route::get('login/line/callback', [LoginController::class, 'handleProviderCallback']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('home', [UserController::class, 'home'])->name('home');
    Route::get('trashbox', [UserController::class, 'trashbox'])->name('trashbox');
    Route::get('account', [UserController::class, 'account'])->name('account');
    Route::get('setting', [UserController::class, 'setting'])->name('setting');

    Route::post('printer', [PriterController::class, 'store'])->name('printer.store');
    Route::put('printer/abailable', [PriterController::class, 'available'])->name('user.printer.available');
    Route::delete('printer/{printer}', [PriterController::class, 'delete'])->name('printer.delete');

    Route::post('albums/{album}/restore', [AlbumController::class, 'restore'])->withTrashed()->name('albums.restore');
    Route::get('albums/{album}', [AlbumController::class, 'show'])->name('albums.show');
    Route::delete('albums/{album}', [AlbumController::class, 'archive'])->name('albums.archive');
    Route::delete('albums/{album}/detach', [AlbumController::class, 'detach'])->withTrashed()->name('albums.detach');
    Route::put('albums/{album}/title', [AlbumController::class, 'title'])->name('albums.title');
    Route::get('albums/{album}/trashbox', [AlbumController::class, 'trashbox'])->name('albums.trashbox');

    Route::put('albums/{album}/photos', [PhotoController::class, 'action'])->name('albums.photos.action');

    Route::get('order/review', [CartItemController::class, 'review'])->name('order.review');
    Route::post('order/checkout', [CartItemController::class, 'checkout'])->name('order.checkout');
    Route::get('order/complete', [CartItemController::class, 'complete'])->name('order.complete');

    Route::post('order', [CartItemController::class, 'store'])->name('order.store');
    Route::get('cart', [CartItemController::class, 'cart'])->name('cart');
    Route::delete('cart/{cartItem}', [CartItemController::class, 'destroy'])->name('cart.delete');
});

Route::get('test', function () {
    return view('test');
})->name('test');