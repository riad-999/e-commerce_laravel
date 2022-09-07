<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromoCodeController;
use App\Http\Controllers\UiController;
use App\Http\Controllers\UserController;
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

Route::controller(UiController::class)
    ->group(
        function () {
            Route::get('/', 'home')->name('home');
        }
    );
// product
Route::get('/products/initial-create', [ProductController::class, 'initial_create'])
    ->name('initial-create-product');
Route::get('/products/create', [ProductController::class, 'create'])
    ->name('create-product');
Route::post('/products/initial-store', [ProductController::class, 'initial_store'])
    ->name('initial-store-product');
Route::post('/products/store', [ProductController::class, 'store'])
    ->name('store-product');
// Route::get('/products/{id}/show', [ProductController::class, 'show'])
//     ->whereNumber('id')->name('product');
Route::get('/products/{id}/edit/', [ProductController::class, 'edit'])
    ->whereNumber('id')->name('edit-product');
Route::get('/products/{id}/colors/edit', [ProductController::class, 'edit_colors'])
    ->whereNumber('id')->name('edit-product-colors');
Route::patch('/products/{id}', [ProductController::class, 'update'])
    ->whereNumber('id')->name("update-product");
Route::patch('/products/{id}/colors', [ProductController::class, 'update_colors'])
    ->whereNumber('id')->name("update-product-colors");
Route::post('/products/{id}/colors', [ProductController::class, 'store_color'])
    ->whereNumber('id')->name("store-product-color");
Route::get('/products/edit/{id}/promo', [ProductController::class, 'edit_promo'])
    ->whereNumber('id')->name('edit-product-promo');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])
    ->whereNumber('id')->name('delete-product');
Route::delete('/products/{product_id}/color/{color_id}', [ProductController::class, 'destroy_color'])
    ->whereNumber(['product_id', 'color_id'])->name('delete-product-color');

Route::get('/products/{id}/promo/edit', [ProductController::class, 'edit_promo'])
    ->whereNumber(['id'])->name('edit-promo');
Route::patch('/products/{id}/promo', [ProductController::class, 'update_promo'])
    ->whereNumber(['id'])->name('update-promo');

Route::get('/admin-products', [ProductController::class, 'admin_index'])
    ->name('admin-products');
Route::get('/products', [ProductController::class, 'index'])
    ->name('products');
Route::get('/products/{id}', [ProductController::class, 'show'])
    ->whereNumber(['id'])->name('show-product');

Route::middleware(['auth', 'admin'])->controller(PromoCodeController::class)
    ->group(function () {
        Route::get('/promo-codes', 'index')->name('promo-codes');
        Route::post('/promo-codes', 'store')->name('store-promo-code');
        Route::get('/promo-codes/{id}/edit', 'edit')->name('edit-promo-code');
        Route::patch('/promo-codes/{id}', 'update')->name('update-promo-code');
        Route::delete('/promo-codes/{id}', 'delete')->name('delete-promo-code');
        Route::get('promo-codes/{id}/assocations', 'promo_code_assocations')
            ->name('promo-code-assocations');
        Route::get('promo-codes/{id}/assocations/create', 'create_promo_code_assocation')
            ->name('create-promo-code-assocations');
        Route::post('promo-codes/{id}/assocations', 'store_promo_code_assocation')
            ->name('store-promo-code-assocations');
        Route::patch('promo-codes/{id}/products/{product_id}', 'update_promo_code_assocation')
            ->name('update-promo-code-assocations');
        Route::delete('promo-codes/{id}/products/{product_id}', 'delete_promo_code_assocation')
            ->name('delete-promo-code-assocations');
    });

//cart 
Route::post('/cart', [CartController::class, 'add'])
    ->name('add-to-cart');
Route::get('/cart', [CartController::class, 'show'])
    ->name('cart');
Route::patch('/cart', [CartController::class, 'update_item_quantity']);
Route::post('/apply-promo-code', [CartController::class, 'apply_promo_code'])
    ->name('apply-promo-code');
Route::post('/remove-promo-code', [CartController::class, 'remove_promo_code'])
    ->name('remove-promo-code');
Route::post('/remove-promo-code', [CartController::class, 'remove_promo_code'])
    ->name('remove-promo-code');
Route::get('/validate-order', [CartController::class, 'validate_order'])
    ->name('validate-order');

// ->middleware(\App\Http\Middleware\Cors::class);
Route::delete('/cart', [CartController::class, 'delete_item'])
    ->name('delete-cart-item');
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
Route::get('/orders/create', [OrderController::class, 'create'])
    ->name('create-order');
Route::post('/orders', [OrderController::class, 'store'])
    ->name('store-order');
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
// user
Route::middleware(['auth'])->controller(UserController::class)
    ->group(function () {
        Route::get('/user', 'show')->name('profile');
        Route::get('/user/orders', 'orders')->name('user-orders');
        Route::get('/user/order/{id}', 'show_order')->name('show-user-orders');
        Route::get('/user/edit',  'edit')->name('edit-profile');
        Route::patch('/user/update', 'update')->name('update-profile');
        Route::get('/user/check-password', 'show_check_password')
            ->name('show-check-password');
        Route::post('/user/check-password', 'check_password')
            ->name('check-password');
        Route::get('/user/edit-password', 'edit_password')
            ->name('edit-password');
        Route::patch('/user/update-password', 'update_password')
            ->name('update-password');
    });
Route::middleware(['guest'])->controller(UserController::class)
    ->group(function () {
        Route::get('/register', [UserController::class, 'create'])
            ->name('create-user');
        Route::post('/register', [UserController::class, 'register'])
            ->name('register');
    });
// auth
Route::middleware(['auth', 'admin'])->controller(AuthController::class)
    ->group(
        function () {
            Route::get('/login', 'show_login')->name('show-login');
            Route::post('/login', 'login')->name('login');
            Route::post('/logout', 'logout')->name('logout');
            Route::post('/set-session', 'set_session')->name('set-session');
        }
    );
Route::middleware(['guest'])->controller(AuthController::class)
    ->group(
        function () {
            Route::get('/forgot-password', 'forgot_password')->name('password.request');
            Route::get('/reset-password/{id}/{hash}', 'show_reset_password')->name('show_reset-password');
            Route::patch('/reset-password/{id}', 'reset_password')->name('reset-password');
        }
    );

// Route::get('/verify-email-notice', [AuthController::class, 'verify_email_notice'])
//     ->name('verify-email-notice');
// Route::get('/resend-verify-email', [AuthController::class, 'resend_verify_email'])
//     ->name('resend-verify-email');
// Route::get('/verify-user-email/{id}/{hash}', [AuthController::class, 'verify_user_email'])
//     ->name('verify-user-email')->whereNumber(['id']);