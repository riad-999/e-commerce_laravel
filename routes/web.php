<?php
/// comms
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\Review;

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
})->name('home');
// products
Route::get('/products', function () {
    Product::all();
})->name('products');
Route::get('/products/initial-create', [ProductController::class, 'initial_create'])
    ->name('initial-create-product');
Route::get('/products/create', [ProductController::class, 'create'])
    ->name('create-product');
Route::post('/products/initial-store', [ProductController::class, 'initial_store'])
    ->name('initial-store-product');
Route::post('/products/store', [ProductController::class, 'store'])
    ->name('store-product');
Route::get('/products/show/{id}', [ProductController::class, 'show'])
    ->whereNumber('id')->name('edit-product');
Route::get('/products/edit/{id}', [ProductController::class, 'edit'])
    ->whereNumber('id')->name('edit-product');
Route::get('/products/edit/{id}/colors', [ProductController::class, 'edit_colors'])
    ->whereNumber('id')->name('edit-product-colors');
Route::get('/products/edit/{id}/promo', [ProductController::class, 'edit_promo'])
    ->whereNumber('id')->name('edit-product-promo');

// product
Route::get('/products', [ProductController::class, 'admin_index'])
    ->name('admin-products');
// category
Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories');
Route::post('/categories', [CategoryController::class, 'store'])
    ->name('store-category');
Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])
    ->whereNumber('id')->name('edit-category');
Route::patch('/categories/{id}', [CategoryController::class, 'update'])
    ->whereNumber('id')->name('update-category');
Route::delete('/categories/{id}', [CategoryController::class, 'delete'])
    ->whereNumber('id')->name('delete-category');
// brand
Route::get('/brands', [BrandController::class, 'index'])
    ->name('brands');
Route::post('/brands', [BrandController::class, 'store'])
    ->name('store-brand');
Route::get('/brands/{id}/edit', [BrandController::class, 'edit'])
    ->whereNumber('id')->name('edit-brand');
Route::patch('/brands/{id}', [BrandController::class, 'update'])
    ->whereNumber('id')->name('update-brand');
Route::delete('/brands/{id}', [BrandController::class, 'delete'])
    ->whereNumber('id')->name('delete-brand');
// clolor 
Route::get('/colors', [ColorController::class, 'index'])
    ->name('colors');
Route::post('/colors', [ColorController::class, 'store'])
    ->name('store-color');
Route::get('/colors/{id}/edit', [ColorController::class, 'edit'])
    ->whereNumber('id')->name('edit-color');
Route::patch('/colors/{id}', [ColorController::class, 'update'])
    ->whereNumber('id')->name('update-color');
Route::delete('/color/{id}', [ColorController::class, 'delete'])
    ->whereNumber('id')->name('delete-color');
// order
Route::get('/orders', [OrderController::class, 'index'])
    ->name('orders');
Route::get('/orders/{id}', [OrderController::class, 'show'])
    ->whereNumber('id')->name('order');
Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])
    ->whereNumber('id')->name('edit-order');
Route::get('/orders/{id}/products/edit', [OrderController::class, 'edit_products'])
    ->whereNumber('id')->name('edit-order-products');

Route::patch('/orders/{id}', [OrderController::class, 'update'])
    ->whereNumber('id')->name('update-order');
Route::patch('/orders/{id}/products', [OrderController::class, 'update_products'])
    ->whereNumber('id')->name('update-order-products');

Route::delete('/orders/{id}', [OrderController::class, 'delete'])
    ->whereNumber('id')->name('delete-order');
Route::delete(
    '/orders/{id}/product/{product_id}/color/{color_id}',
    [OrderController::class, 'delete_product']
)->whereNumber(['id', 'product_id', 'color_id'])
    ->name('delete-order-product');

Route::get('/reviews', function () {
    Review::filter(9, 2);
});

// Route::get('/brands', function () {
//     Color::all();
// });