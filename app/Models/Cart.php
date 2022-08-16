<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    public static function cart($cart, $promo_code = null)
    {
        if (!count($cart)) {
            return [];
        }
        $cart = collect($cart);
        $product_ids = $cart->map(fn ($item) => $item->product_id)
            ->unique()->toArray();
        $color_ids = $cart->map(fn ($item) => $item->color_id)
            ->unique()->toArray();
        $products = DB::table('products')
            ->join('brands', 'brand_id', '=', 'brands.id')
            ->select(['products.*', 'brands.name as brand'])
            ->whereIn('products.id', $product_ids)->get();
        $colors = DB::table('color_product')
            ->join('colors', 'color_id', '=', 'colors.id')
            ->select(['main_image', 'color_product.quantity as max', 'product_id', 'colors.*'])
            ->whereIn('color_id', $color_ids)->get();
        foreach ($products as $product) {
            $product->colors = [];
            foreach ($colors as $color) {
                if ($color->product_id != $product->id)
                    continue;
                array_push($product->colors, $color);
            }
        }
        foreach ($cart as $item) {
            foreach ($products as $product) {
                if ($item->product_id != $product->id)
                    continue;
                foreach ($product->colors as $color) {
                    if ($item->color_id != $color->id)
                        continue;
                    $item->name = $product->name;
                    $item->price = $product->price;
                    $item->promo = $product->promo;
                    $item->brand = $product->brand;
                    $item->image = $color->main_image;
                    $item->max = $color->max;
                    $item->color = $color;
                }
            }
        }

        return $cart->toArray();
    }
}