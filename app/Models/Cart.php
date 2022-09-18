<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    public static function cart($cart, $promo_code_id)
    {
        if (!count($cart)) {
            return [];
        }
        $code = $promo_code_id ? PromoCode::get($promo_code_id) : null;
        $cart = collect($cart);
        $product_ids = $cart->map(fn ($item) => $item->product_id)
            ->unique()->toArray();
        $color_ids = $cart->map(fn ($item) => $item->color_id)
            ->unique()->toArray();
        $query = DB::table('products')
            ->join('brands', 'brand_id', '=', 'brands.id')
            ->select(['products.*', 'brands.name as brand']);
        if (!$code) {
            $query->selectRaw('NULL as cut');
        } elseif ($code->for_all) {
            $query->selectRaw('? as cut', [$code->for_all_cut]);
        } else {
            $query->selectRaw(
                '(select cut from product_promo where product_id = products.id and promo_code_id = ?) as cut',
                [$code->id]
            );
        }
        $products = $query->whereIn('products.id', $product_ids)
            ->where('deleted', '=', 0)->get();
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
                    $item->cut = $product->cut;
                }
            }
        }
        return $cart->toArray();
    }
}