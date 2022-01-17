<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/login/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/login/google/callback', [GoogleController::class, 'callback']);

// Route::get('/login/twitter', [TwitterController::class, 'redirect'])->name('twitter.login');;
// Route::get('/login/twitter/callback', [TwitterController::class, 'callback']);