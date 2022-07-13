<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Product
{
    public static function all($request = null, $admin = false, $orderby = 'latest')
    {
        // filters.
        $name = 'se';
        $cats = json_decode('["voluptatem", "et"]');
        $brands = json_decode('["dolore", "illo"]');
        $promo = true;
        // $id = $admin ? 5 : null;
        $id = 5;
        // getting all products according to filters.
        if ($id) {
            $products = DB::table('products')
                ->join('brands', 'brand_id', '=', 'brands.id')
                ->join('categories', 'category_id', '=', 'categories.id')
                ->select(['products.*', 'brands.name as brand', 'categories.name as category'])
                ->where('products.id', '=', $id)
                ->orderByDesc('products.id')->get();
        } else {
            $products = DB::table('products')
                ->join('brands', 'brand_id', '=', 'brands.id')
                ->join('categories', 'category_id', '=', 'categories.id')
                ->select(['products.*', 'brands.name as brand', 'categories.name as category'])
                ->when(!$admin, function ($query) {
                    $query->where('archived', '=', 0);
                })
                ->when($name, function ($query, $name) {
                    $query->where('products.name', 'like', "%$name%");
                })
                ->when($cats, function ($query, $cats) {
                    $query->whereIn('categories.name', $cats);
                })
                ->when($brands, function ($query, $brands) {
                    $query->whereIn('brands.name', $brands);
                })
                ->when($promo, function ($query) {
                    $query->whereNotNull('promo');
                })
                ->orderByDesc('products.id')->paginate(30);
            $products = $products->items();
            $products = collect($products);
        }
        // getting products colors.
        $ids = [];
        foreach ($products as $product) {
            array_push($ids, $product->id);
        }
        $colors = DB::table('color_product')
            ->join('colors', 'color_id', '=', 'colors.id')
            ->select(['color_id', 'product_id', 'name', 'value', 'main_image'])
            ->whereIn('product_id', $ids)
            ->where('quantity', '>', 0)->get();
        // associating each product with its colors
        $products = $products->map(function ($product) use ($colors) {
            $product->colors = [];
            foreach ($colors as $color) {
                if ($product->id == $color->product_id)
                    array_push($product->colors, $color);
            }
            return $product;
        });
        dd($products);
        return $products;
    }

    public static function get($id)
    {
        $product = DB::table('products')
            ->join('brands', 'brand_id', '=', 'brands.id')
            ->join('categories', 'category_id', '=', 'categories.id')
            ->select(
                [
                    'products.*', 'brands.name as brand',
                    'categories.name as category'
                ]
            )
            ->where('products.id', '=', $id)->get()->first();
        if (!$product)
            return null;
        // product colors.
        $colors = DB::table('color_product')
            ->join('colors', 'color_id', '=', 'colors.id')
            ->select(['id', 'main_image', 'value'])
            ->where('product_id', '=', $id)
            ->get();
        // geting product images for each color.
        $color_ids = [];
        foreach ($colors as $color) {
            array_push($color_ids, $color->id);
        }
        $images = DB::table('products_images')
            ->select(['color_id', 'url'])->where('product_id', '=', $id)
            ->whereIn('color_id', $color_ids)->get();
        // associating images to product colors
        $colors = $colors->map(function ($color) use ($images) {
            $color->images = [];
            foreach ($images as $image) {
                if ($image->color_id == $color->id) {
                    array_push($color->images, $image);
                }
            }
            return $color;
        });
        $product->colors = $colors;
        // getting product reviews.
        $reviews = DB::table('reviews')
            ->join('users', 'user_id', '=', 'users.id')
            ->select(['users.name as name', 'score', 'feedback', 'reviews.created_at as date'])
            ->where('product_id', '=', $id)->get();
        $product->reviews = $reviews;
        // counting product orders
        $solds = DB::table('order_product_color')
            ->selectRaw('sum(quantity) as solds')
            ->where('product_id', '=', $id)
            ->get()->first()->solds;
        $product->solds = $solds;

        return $product;
    }
}