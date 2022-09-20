<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('id')
                ->constrained('categories')->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->after('id')
                ->constrained('brands')->nullOnDelete();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')
                ->constrained('users')->nullOnDelete();
            $table->unsignedInteger('wilaya_id')->after('user_id');
            $table->foreign('wilaya_id')->references('id')
                ->on('wilayas');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->first()->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('product_id')
                ->after('user_id')->constrained('products');
            $table->primary(['product_id', 'user_id']);
        });

        Schema::table('color_product', function (Blueprint $table) {

            $table->foreignId('product_id')
                ->first()->constrained('products')->cascadeOnDelete();
            $table->foreignId('color_id')->after('product_id')
                ->constrained('colors')->cascadeOnUpdate();
            $table->primary(['product_id', 'color_id']);
        });

        Schema::table('products_images', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')
                ->after('id');
            $table->unsignedBigInteger('color_id')
                ->after('product_id');
            $table->foreign(['product_id', 'color_id'])
                ->references(['product_id', 'color_id'])
                ->on('color_product')->cascadeOnUpdate()
                ->cascadeOnDelete();
        });

        Schema::table('order_product_color', function (Blueprint $table) {
            $table->foreignId('order_id')
                ->first()->constrained('orders')->cascadeOnDelete();
            $table->unsignedBigInteger('product_id')
                ->after('order_id');
            $table->unsignedBigInteger('color_id')
                ->after('product_id');
            $table->primary(['order_id', 'product_id', 'color_id']);
            $table->foreign(['product_id', 'color_id'])
                ->references(['product_id', 'color_id'])
                ->on('color_product')->cascadeOnUpdate();
        });

        Schema::table('product_promo', function (Blueprint $table) {
            $table->foreignId('product_id')
                ->first()->constrained('products')
                ->cascadeOnDelete();
            $table->foreignId('promo_code_id')
                ->after('product_id')->constrained('promo_codes')
                ->cascadeOnDelete();
            $table->primary(['product_id', 'promo_code_id']);
        });

        Schema::table('promo_user', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->first()->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('promo_code_id')
                ->after('user_id')->constrained('promo_codes')
                ->cascadeOnDelete();
            $table->dropColumn('dummy');
        });

        Schema::table('saves', function (Blueprint $table) {
            $table->foreignId('product_id')->first()
                ->constrained('products')->cascadeOnDelete();
            $table->foreignId('user_id')
                ->after('product_id')->constrained('users')
                ->cascadeOnDelete();
            $table->primary(['product_id', 'user_id']);
            $table->dropColumn('dummy');
        });

        Schema::table('users_addresses', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->nullable()
                ->constrained('users')->cascadeOnDelete();
            $table->unsignedInteger('wilaya_id')->nullable();
            $table->foreign('wilaya_id')->references('id')
                ->on('wilayas')->nullOnDelete();
        });
    }
};