<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('intro');

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->name('login');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Route::middleware(['auth'])->group(function () {
//     Route::get('home', 'HomeController@index')->name('home');
// });

Route::get('home', [HomeController::class, 'home'])->name('home');
Route::get('pp', [HomeController::class, 'pp'])->name('pp');
Route::get('terms', [HomeController::class, 'terms'])->name('terms');