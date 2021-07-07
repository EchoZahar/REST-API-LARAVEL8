<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('l5-swagger.default.api');
});
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
