<?php

use App\Http\Controllers\ProductController;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Barryvdh\Debugbar\Facades\Debugbar;
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
    return view('home');
});
Route::get('/products', function () {
    Product::all();
});

Route::get('/products/create', [ProductController::class, 'create']);
Route::post('/products/create', [ProductController::class, 'create']);
Route::post('/products/store', [ProductController::class, 'store']);

Route::get('/orders', function () {
    $order = Order::all()->first();
    $order = Order::getOrderWithDetails($order);
    dd($order);
});

Route::get('/reviews', function () {
    Review::filter(9, 2);
});

Route::get('/brands', function () {
    Color::all();
});