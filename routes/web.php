<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/generateData', [ProductController::class, 'generateData']);
Route::get('/', [ProductController::class, 'index']);
Route::resource('home', ProductController::class)->parameters([
    'produk' => 'id_produk',
]);
