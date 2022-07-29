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
            $table->foreignId('category_id')->after('id')
                ->constrained('categories')->restrictOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('brand_id')->after('id')
                ->constrained('brands')->restrictOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')
                ->constrained('users');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->after('id')->constrained('users');
            $table->foreignId('product_id')
                ->after('id')->constrained('products');
        });

        Schema::table('color_product', function (Blueprint $table) {

            $table->foreignId('product_id')
                ->first()->constrained('products');
            $table->foreignId('color_id')->after('product_id')
                ->constrained('colors')->cascadeOnUpdate()->restrictOnDelete();
            $table->primary(['product_id', 'color_id']);
        });

        Schema::table('products_images', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')
                ->after('id');
            $table->unsignedBigInteger('color_id')
                ->after('product_id');
            $table->foreign(['product_id', 'color_id'])
                ->references(['product_id', 'color_id'])
                ->on('color_product');
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
                ->on('color_product');
        });

        Schema::table('saves', function (Blueprint $table) {
            $table->foreignId('product_id')->first()
                ->constrained('products');
            $table->foreignId('user_id')
                ->after('product_id')->constrained('users');
            $table->primary(['product_id', 'user_id']);
            $table->dropColumn('dummy');
        });
    }
};