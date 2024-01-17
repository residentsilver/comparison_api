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


//楽天の情報を削除
Route::delete('/index/{comparison}', [RakutenController::class, 'delete']);

//楽天の情報を取得
Route::get('/get-rakuten-items', [RakutenController::class, 'get_rakuten_items']);
Route::get('/search', [RakutenController::class, 'searchItems'])->name('search');

//楽天の情報を格納
Route::post('product_save',[RakutenController::class,'save']);

//楽天の格納情報を表示
Route::get('/index', [RakutenController::class, 'index']);

//楽天の格納情報を部分一致検索
Route::get('/index-search', [RakutenController::class, 'index_search']);

//amazonの情報を取得したい
Route::get('/amazon', [AmazonController::class, '']);

//ソート機能
Route::post('/product_sort', 'RakutenController@save')->name('product.save');


