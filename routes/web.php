<?php

use App\Http\Controllers\UserAuthController;
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


Route::get('/login',[UserAuthController::class, 'getLogin'])->name('login');
Route::post('/login' , [UserAuthController::class, 'loginHandler'])->name('handleLogin');   
Route::get('/register' , [UserAuthController::class, 'getRegister'])->name('register');
Route::post('/register', [UserAuthController::class, 'registerHandler'])->name('handleRegister');

Route::get('/', function () {
    return view('welcome');
});
