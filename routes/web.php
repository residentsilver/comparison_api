<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| 楽天 Routes
|--------------------------------------------------------------------------
|
*/
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



//ソート機能
Route::post('/product_sort', 'RakutenController@save')->name('product.save');
/*
|--------------------------------------------------------------------------
| 楽天 Routes
|--------------------------------------------------------------------------
|
*/

//amazonの情報を取得したい
Route::get('/amazon', [AmazonController::class, '']);