<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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
    return view('Auth.index');
});

Route::get('/register',function () {
    return view('Auth.register');
});

Route::get('/password',function () {
    return view('Auth.password');
});

Route::get('/login',function () {
    return view('Auth.login');
});


Route::post('/signup', [LoginController::class, 'store']);
Route::post('/login', [LoginController::class, 'show']);
Route::get('logout', [LoginController::class, 'logout']);

Route::get('login/{service}', [LoginController::class, 'redirectToProvider']);
Route::get('login/{service}/callback', [LoginController::class, 'handleProviderCallback']);