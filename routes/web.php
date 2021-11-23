<?php

use App\Http\Controllers\BookPostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Firebase\LoginController;
use App\Http\Controllers\FirebaseController;
use App\Http\Controllers\UserPostController;
use Kreait\Laravel\Firebase\Facades\Firebase;

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

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'authenticate']);
Route::get('/dashboard', function(){
    return view('dashboard.pages.index');
})->middleware('admin');
    
Route::get('/register', [FirebaseController::class, 'signUp']);

Route::post('/login', [FirebaseController::class, 'login']);
Route::post('/logout', [FirebaseController::class, 'logout']);

Route::resource('/books', BookPostController::class)->middleware('admin')->middleware('sweet');

Route::resource('/users', UserPostController::class)->middleware('admin')->middleware('sweet');

Route::get('/phpinfo', function(){
    return view('phpinfo');
})->middleware('admin');