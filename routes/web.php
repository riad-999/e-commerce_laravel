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
use App\Http\Controllers\WilayaController;
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
            Route::get('/home/edit', 'edit')
                ->middleware(['auth', 'admin'])->name('edit-home');
            Route::patch('/home/update', 'update')
                ->middleware(['auth', 'admin'])->name('update-home');
            Route::get('/dashboard', 'dashboard')
                ->middleware(['auth', 'admin'])->name('dashboard');
        }
    );
// product
Route::middleware(['auth', 'admin'])->controller(ProductController::class)
    ->group(
        function () {
            Route::get('/products/initial-create', 'initial_create')->name('initial-create-product');
            Route::get('/products/create', 'create')->name('create-product');
            Route::post('/products/initial-store', 'initial_store')->name('initial-store-product');
            Route::post('/products/store', 'store')->name('store-product');
            Route::get('/products/{id}/edit/', 'edit')->whereNumber('id')->name('edit-product');
            Route::get('/products/{id}/colors/edit', 'edit_colors')->whereNumber('id')->name('edit-product-colors');
            Route::patch('/products/{id}', 'update')->whereNumber('id')->name("update-product");
            Route::patch('/products/{id}/colors', 'update_colors')->whereNumber('id')->name("update-product-colors");
            Route::post('/products/{id}/colors', 'store_color')->whereNumber('id')->name("store-product-color");
            Route::get('/products/edit/{id}/promo', 'edit_promo')->whereNumber('id')->name('edit-product-promo');
            Route::delete('/products/{id}', 'destroy')->whereNumber('id')->name('delete-product');
            Route::delete('/products/{product_id}/color/{color_id}', 'destroy_color')
                ->whereNumber(['product_id', 'color_id'])->name('delete-product-color');
            Route::get('/products/{id}/promo/edit', 'edit_promo')->whereNumber(['id'])->name('edit-promo');
            Route::patch('/products/{id}/promo', 'update_promo')->whereNumber(['id'])->name('update-promo');
            Route::get('/admin-products', 'admin_index')->name('admin-products');
        }
    );
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{id}', [ProductController::class, 'show'])
    ->whereNumber(['id'])->name('show-product');
// wilayas 
Route::middleware(['auth', 'admin'])->controller(WilayaController::class)
    ->group(
        function () {
            Route::get('/wilayas', 'index')->name('wilayas');
            Route::post('/wilayas', 'store')->name('store-wilaya');
            Route::get('/wilayas/{id}/edit', 'edit')->name('edit-wilaya');
            Route::patch('/wilayas/{id}', 'update')->name('update-wilaya');
            Route::delete('/wilayas/{id}', 'delete')->name('delete-wilaya');
        }
    );
// promo codes 
Route::middleware(['auth', 'admin'])->controller(PromoCodeController::class)
    ->group(
        function () {
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
        }
    );

//cart 
Route::post('/cart', [CartController::class, 'add'])
    ->name('add-to-cart');
Route::post('/order-product', [CartController::class, 'order'])
    ->name('order-product');
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
Route::delete('/cart', [CartController::class, 'delete_item'])
    ->name('delete-cart-item');
// category
Route::middleware(['auth', 'admin'])->controller(CategoryController::class)
    ->group(
        function () {
            Route::get('/categories',  'index')->name('categories');
            Route::post('/categories', 'store')->name('store-category');
            Route::get('/categories/{id}/edit', 'edit')
                ->whereNumber('id')->name('edit-category');
            Route::patch('/categories/{id}', 'update')
                ->whereNumber('id')->name('update-category');
            Route::delete('/categories/{id}', 'delete')
                ->whereNumber('id')->name('delete-category');
        }
    );
// brand
Route::middleware(['auth', 'admin'])->controller(BrandController::class)
    ->group(
        function () {
            Route::get('/brands', 'index')->name('brands');
            Route::post('/brands',  'store')->name('store-brand');
            Route::get('/brands/{id}/edit', 'edit')->whereNumber('id')->name('edit-brand');
            Route::patch('/brands/{id}', 'update')->whereNumber('id')->name('update-brand');
            Route::delete('/brands/{id}', 'delete')->whereNumber('id')->name('delete-brand');
        }
    );
// clolor 
Route::middleware(['auth', 'admin'])->controller(ColorController::class)
    ->group(
        function () {
            Route::get('/colors', 'index')->name('colors');
            Route::post('/colors', 'store')->name('store-color');
            Route::get('/colors/{id}/edit', 'edit')
                ->whereNumber('id')->name('edit-color');
            Route::patch('/colors/{id}', 'update')
                ->whereNumber('id')->name('update-color');
            Route::delete('/color/{id}', 'delete')
                ->whereNumber('id')->name('delete-color');
        }
    );
// order
Route::middleware(['auth', 'admin'])->controller(OrderController::class)
    ->group(
        function () {
            Route::get('/orders',  'index')->name('orders');
            Route::get('/orders/{id}', 'show')->whereNumber('id')->name('order');
            Route::get('/orders/{id}/edit', 'edit')->whereNumber('id')->name('edit-order');
            Route::get('/orders/{id}/products/edit', 'edit_products')
                ->whereNumber('id')->name('edit-order-products');
            Route::patch('/orders/{id}', 'update')->whereNumber('id')->name('update-order');
            Route::patch('/orders/{id}/products', 'update_products')
                ->whereNumber('id')->name('update-order-products');
            Route::delete('/orders/{id}', 'delete')->whereNumber('id')->name('delete-order');
            Route::delete(
                '/orders/{id}/product/{product_id}/color/{color_id}',
                'delete_product'
            )->whereNumber(['id', 'product_id', 'color_id'])
                ->name('delete-order-product');
        }
    );
Route::get('/orders/create', [OrderController::class, 'create'])
    ->name('create-order');
Route::post('/orders', [OrderController::class, 'store'])
    ->name('store-order');
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
        Route::get('/users', 'index')
            ->middleware(['admin'])->name('users');
        Route::post('/saves', 'save_product')->name('save-product');
        Route::get('/saves', 'saved_products')->name('saved-products');
        Route::get('/wait-to-review', 'pending_reviews')->name('pending-reviews');
        Route::post('/reviews/{id}', 'store_review')->name('store-review');
        Route::patch('/reviews/{product_id}/{user_id}', 'delete_feedback')->name('delete-feeback');
        // Route::delete('/saves', 'unsave_product')->name('unsave-product');
    });
Route::middleware(['auth', 'admin', 'privileged'])->controller(UserController::class)
    ->group(function () {
        Route::get('/admins', 'admins')->name('admins');
        Route::post('/admins', 'store_admin')->name('store-admin');
        Route::delete('/admins/{id}', 'delete')->name('delete-user');
    });
Route::middleware(['guest'])->controller(UserController::class)
    ->group(function () {
        Route::get('/register', [UserController::class, 'create'])
            ->name('create-user');
        Route::post('/register', [UserController::class, 'register'])
            ->name('register');
    });
// auth
Route::middleware(['auth'])->controller(AuthController::class)
    ->group(
        function () {
            Route::post('/logout', 'logout')->name('logout');
        }
    );
Route::middleware(['guest'])->controller(AuthController::class)
    ->group(
        function () {
            Route::get('/login', 'show_login')->name('show-login');
            Route::post('/login', 'login')->name('login');
            Route::post('/set-session', 'set_session')->name('set-session');
            Route::get('/forgot-password', 'forgot_password')->name('password.request');
            Route::post('/handle-forget-password', 'handle_forgot_password')
                ->name('password.email')->middleware('throttle:5,60');
            Route::get('/reset-password/{id}/{hash}', 'show_reset_password')
                ->name('show_reset-password');
            Route::patch('/reset-password/{id}', 'reset_password')->name('reset-password');
        }
    );

// Route::get('/verify-email-notice', [AuthController::class, 'verify_email_notice'])
//     ->name('verify-email-notice');
// Route::get('/resend-verify-email', [AuthController::class, 'resend_verify_email'])
//     ->name('resend-verify-email');
// Route::get('/verify-user-email/{id}/{hash}', [AuthController::class, 'verify_user_email'])
//     ->name('verify-user-email')->whereNumber(['id']);