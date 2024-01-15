<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\RakutenController;
use App\Http\Controllers\AmazonController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//削除
Route::delete('/index/{guest}', [RakutenController::class, 'delete']);

//楽天の情報を取得
Route::get('/get-rakuten-items', [RakutenController::class, 'get_rakuten_items']);
Route::get('/search', [RakutenController::class, 'searchItems'])->name('search');

//楽天の情報を格納
Route::post('product_save',[RakutenController::class,'save']);

//楽天の格納情報を表示
Route::get('/index', [RakutenController::class, 'index']);

//amazonの情報を取得したい
Route::get('/amazon', [AmazonController::class, '']);
