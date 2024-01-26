<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\RakutenController;
use App\Http\Controllers\AmazonController;
use App\Http\Controllers\AmazonCurlController;
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


Route::get('/top', [ComparisonController::class, 'Top'])->middleware('auth');

/*
|--------------------------------------------------------------------------
| 楽天 Routes
|--------------------------------------------------------------------------
|
*/

//楽天のトップページを表示する
Route::get('/rakuten', [RakutenController::class, 'RakutenTop'])->middleware('auth');

//楽天の情報を削除
Route::delete('/index/{comparison}', [RakutenController::class, 'delete'])->middleware('auth');

//楽天の情報を取得(ページネーション)
Route::get('/rakuten-search/{page}', [RakutenController::class, 'get_rakuten_items'])->name('search')->middleware('auth');

//1ページで5回のAPIを取得している
// Route::get('/rakuten-search', [RakutenController::class, 'searchItems'])->name('search')->middleware('auth');

//楽天の情報を格納
Route::post('product_save',[RakutenController::class,'save'])->middleware('auth');

//楽天の格納情報を表示
Route::get('/index', [RakutenController::class, 'index'])->middleware('auth');

//楽天の格納情報を部分一致検索
Route::get('/index-search', [RakutenController::class, 'index_search'])->middleware('auth');

/*
|--------------------------------------------------------------------------
| amazon Routes
|--------------------------------------------------------------------------
|
*/

//amazonの情報を取得したい
Route::get('/amazon', [AmazonCurlController::class, 'AmazonTop'])->middleware('auth');
Route::post('/amazon', [AmazonCurlController::class, 'AmazonTop'])->middleware('auth');

Route::get('/amazon-search', [AmazonCurlController::class, 'searchAmazonProducts'])->middleware('auth');
Route::post('/amazon-search', [AmazonCurlController::class, 'searchAmazonProducts'])->middleware('auth');

Route::post('amazon_save',[AmazonCurlController::class,'save'])->middleware('auth');


/*
|--------------------------------------------------------------------------
|test
|--------------------------------------------------------------------------
|
*/
