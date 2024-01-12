<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\RakutenController;

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

Route::post('product_save',[RakutenController::class,'save']);

Route::get('/search', [RakutenController::class, 'searchItems'])->name('search');

Route::get('/index', [RakutenController::class, 'index']);

Route::delete('/index/{guest}', [RakutenController::class, 'delete']);//削除