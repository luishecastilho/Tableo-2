<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    AuthController,
    IndexController
};

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


Route::get('/', [IndexController::class, 'index'])->name('index');
Route::post('signup', [AuthController::class, 'signup'])->name('signup');
Route::post('login', [AuthController::class, 'login'])->name('login');

// authed
Route::get('quotes', [IndexController::class, 'quotes'])->name('quotes');
