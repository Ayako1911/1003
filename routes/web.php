<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// ↓は、デプロイ用のルート
Route::post('/store', [HomeController::class, 'index'])->name('store');
Route::get('/edit/{id}', [HomeController::class, 'index'])->name('edit');

// デプロイのため、以下の３つのルートはコメントアウト
// Route::post('/store', [HomeController::class, 'store'])->name('store');
// Route::get('/edit/{id}', [HomeController::class, 'edit'])->name('edit');
// Route::post('/update', [HomeController::class, 'update'])->name('update');

Route::post('/destory', [HomeController::class, 'destory'])->name('destory');