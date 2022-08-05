<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Product
{
    public static function all($request)
    {
        $currentPage = 1;
        $lastPage = 1;
        $nextPage = 1;
        $previousPage = 1;
        if ($id = $request->input('id')) {
            $products = DB::table('products')
                ->join('brands', 'brand_id', '=', 'brands.id')
                ->join('categories', 'category_id', '=', 'categories.id')
                ->select(['products.*', 'brands.name as brand', 'categories.name as category'])
                ->where('deleted', '=', 0)
                ->where('products.id', '=', $id)
                ->orderByDesc('products.id')->get();
        } else {
            $pagination = DB::table('products')
                ->join('brands', 'brand_id', '=', 'brands.id')
                ->join('categories', 'category_id', '=', 'categories.id')
                ->select(['products.*', 'brands.name as brand', 'categories.name as category'])
                // ->when(!$admin, function ($query) use ($request) {
                //     $query->where('deleted', '=', 0);
                // })
                // ->when($request->has('archived'), function ($query) {
                //     $query->where('archived', '=', 1);
                // })
                ->where('deleted', '=', 0)
                ->when($request->input('name'), function ($query, $name) {
                    $query->where('products.name', 'like', "%$name%");
                })
                ->when($request->input('categories'), function ($query, $cats) {
                    $query->whereIn('categories.name', json_decode($cats));
                })
                ->when($request->input('brands'), function ($query, $brands) {
                    $query->whereIn('brands.name', json_decode($brands));
                })
                ->when($request->has('promo'), function ($query) {
                    $query->whereNotNull('promo');
                })
                ->orderByDesc('products.id')->paginate(20);
            $currentPage = $pagination->currentPage();
            $lastPage = $pagination->lastPage();
            $nextPage = $currentPage >= $lastPage ? $lastPage : $currentPage + 1;
            $previousPage = $currentPage <= 1 ? 1 : $currentPage - 1;
            $products = collect($pagination->items());
        }
        // getting products colors.
        $ids = [];
        foreach ($products as $product) {
            array_push($ids, $product->id);
        }
        $colors = DB::table('color_product')
            ->join('colors', 'color_id', '=', 'colors.id')
            ->select([
                'color_id', 'product_id',
                'name', 'value1', 'value2',
                'value3', 'main_image'
            ])
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
        return (object)[
            'products' => $products,
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
            'nextPage' => $nextPage,
            'previousPage' => $previousPage
        ];
    }

    public static function get($id, $withColors = false, $withReviews = false, $withCount = false)
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
            ->where('deleted', '=', 0)
            ->where('products.id', '=', $id)->get()->first();
        if (!$product)
            return null;
        // product colors.
        if ($withColors) {
            $colors = DB::table('color_product')
                ->join('colors', 'color_id', '=', 'colors.id')
                ->select(['id', 'color_id', 'name', 'quantity', 'deleted', 'main_image', 'value1', 'value2', 'value3'])
                ->where('deleted', '=', 0)
                ->where('product_id', '=', $id)
                ->get();
            // geting product images for each color.
            $color_ids = [];
            foreach ($colors as $color) {
                array_push($color_ids, $color->id);
            }
            $images = DB::table('products_images')
                ->select(['color_id', 'image'])->where('product_id', '=', $id)
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
        }
        if ($withReviews) {
            // getting product reviews.
            $reviews = DB::table('reviews')
                ->join('users', 'user_id', '=', 'users.id')
                ->select(['users.name as name', 'score', 'feedback', 'reviews.created_at as date'])
                ->where('product_id', '=', $id)->get();
            $product->reviews = $reviews;
        }
        if ($withCount) {
            // counting product orders
            $solds = DB::table('order_product_color')
                ->selectRaw('sum(quantity) as solds')
                ->where('product_id', '=', $id)
                ->get()->first()->solds;
            $product->solds = $solds;
        }

        return $product;
    }
    public static function store_color($data, $images)
    {
        DB::table('color_product')->insert($data);
        if (!$images)
            return;
        foreach ($images as $image) {
            DB::table('products_images')->insert([
                'product_id' => $data['product_id'],
                'color_id' => $data['color_id'],
                'image' => $image
            ]);
        }
    }
    public static function update($id, $data)
    {
        DB::table('products')->where('id', '=', $id)
            ->update($data);
    }
    public static function update_colors($id, $data)
    {
        foreach ($data as $item) {
            DB::table('color_product')
                ->where('color_id', '=', $item->id)
                ->where('product_id', '=', $id)
                ->update($item->data);
            if (!$item->images)
                continue;
            DB::table('products_images')
                ->where('color_id', '=', $item->data['color_id'])
                ->where('product_id', '=', $id)
                ->delete();
            foreach ($item->images as $image) {
                DB::table('products_images')
                    ->insert([
                        'product_id' => $id,
                        'color_id' => $item->data['color_id'],
                        'image' => $image
                    ]);
            }
        }
    }
    public static function delete($id)
    {
        $product = self::get($id, true);
        $orders = DB::table('order_product_color')
            ->where('product_id', '=', $id)->get();
        if (!$orders->first()) {
            DB::table('products')->where('id', '=', $id)
                ->delete();
            foreach ($product->colors as $color) {
                self::delete_color($id, $color->id, $color);
            }
        } else {
            DB::table('products')->where('id', '=', $id)
                ->update(['deleted' => 1]);
            foreach ($product->colors as $color) {
                if (!$color->deleted)
                    self::delete_color($id, $color->id, $color);
            }
        }
    }
    public static function delete_color($product_id, $color_id, $color)
    {
        $orders = DB::table('order_product_color')
            ->where('product_id', '=', $product_id)
            ->where('color_id', '=', $color_id)->get();
        if (!$orders->first()) {
            DB::table('color_product')->where('product_id', '=', $product_id)
                ->where('color_id', '=', $color_id)->delete();
            Storage::delete("public/uploads/$color->main_image");
            foreach ($color->images as $image) {
                Storage::delete("public/uploads/$image->image");
            }
        } else {
            DB::table('color_product')->where('product_id', '=', $product_id)
                ->where('color_id', '=', $color_id)->update(['deleted' => 1]);
            foreach ($color->images as $image) {
                Storage::delete("public/uploads/$image->image");
            }
        }
    }
}