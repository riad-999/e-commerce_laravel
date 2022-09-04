<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class PromoCode
{
    public static function all()
    {
        return DB::table('promo_codes')->get();
    }
    public static function insert($data)
    {
        DB::table('promo_codes')->insert($data);
    }
    public static function get($id, $with_product_assoc_count = false, $with_user_assoc_count = null)
    {
        $promo_code =  DB::table('promo_codes')->where('id', '=', $id)
            ->first();
        if (!$promo_code)
            return null;
        $cuts = null;
        $used = null;
        if ($with_product_assoc_count)
            $cuts =  DB::table('product_promo')
                ->where('promo_code_id', '=', $id)
                ->selectRaw('cut, count(*) as products')
                ->groupBy(['cut'])->get();
        if ($with_user_assoc_count)
            $used = DB::table('promo_user')->where('promo_code_id', '=', $id)
                ->first() ? true : false;
        $promo_code->cuts = $cuts;
        $promo_code->used = $used;
        return $promo_code;
    }
    public static function get_by_code($code)
    {
        return DB::table('promo_codes')
            ->where('code','=',$code)->first();
    }
    public static function get_cut($code_id, $cut)
    {
        return DB::table('product_promo')
            ->join('products', 'product_id', '=', 'id')
            ->where('promo_code_id', '=', $code_id)
            ->where('cut', '=', $cut)->get();
    }
    public static function update($id, $data)
    {
        DB::table('promo_codes')->where('id', '=', $id)
            ->update($data);
    }
    // public static function add_cut($id, $cut)
    // {
    // }
    // public static function update_cut($id, $cut, $new_cut)
    // {
    //     DB::table('product_promo')
    //         ->where('promo_code_id', '=', $id)
    //         ->where('cut', '=', $cut)->update(['cut' => $new_cut]);
    // }
    //     public static function check_cut($id, $cut)
    //     {
    //         return DB::table('product_promo')
    //             ->where('promo_code_id', '=', $id)
    //             ->where('cut', '=', $cut)->first();
    //     }
    public static function get_associations($id, $request)
    {
        $code = self::get($id);
        if (!$code)
            return null;
        $pagination = DB::table('product_promo')
            ->join('products', 'product_id', '=', 'id')
            ->select(['id', 'cut', 'name', 'price', 'promo'])
            ->selectRaw('(select main_image from color_product where product_id = product_promo.product_id limit 1) as main_image')
            ->where('promo_code_id', '=', $id)->orderBy('cut')
            ->when($request->input('id'), function ($query, $product_id) {
                $query->where('id', '=', $product_id);
            })
            ->when(
                !$request->input('id') || $request->input('search') ? $request->input('search') : null,
                function ($query, $search) {
                    $query->where('name', 'like', "%$search%");
                }
            )
            ->when(
                !$request->input('id') || $request->input('cut') ? $request->input('cut') : null,
                function ($query, $cut) {
                    $query->where('cut', '=', $cut);
                }
            )
            ->paginate(24);
        $currentPage = $pagination->currentPage();
        $lastPage = $pagination->lastPage();
        return (object)[
            'products' => $pagination->items(),
            'code' => $code,
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
            'nextPage' => $currentPage >= $lastPage ? $currentPage : $currentPage + 1,
            'previousPage' => $currentPage <= 1 ? 1 : $currentPage - 1,
            'total' => $pagination->total()
        ];
    }
    public static function products($id, $request)
    {
        if (!$code = self::get($id))
            return null;
        $pagination = DB::table('products')
            ->select(['id', 'name', 'price', 'promo'])
            ->selectRaw('(select cut from product_promo where product_id = products.id and promo_code_id = ?) as cut', [$id])
            ->selectRaw('(select main_image from color_product where product_id = products.id limit 1) as main_image')
            ->where('deleted', '=', 0)
            ->when($request->input('id'), function ($query, $product_id) {
                $query->where('id', '=', $product_id);
            })
            ->when(
                !$request->input('id') || $request->input('search') ? $request->input('search') : null,
                function ($query, $search) {
                    $query->where('name', 'like', "%$search%");
                }
            )
            ->paginate(20);
        $currentPage = $pagination->currentPage();
        $lastPage = $pagination->lastPage();
        return (object)[
            'products' => $pagination->items(),
            'code' => $code,
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
            'nextPage' => $currentPage >= $lastPage ? $currentPage : $currentPage + 1,
            'previousPage' => $currentPage <= 1 ? 1 : $currentPage - 1,
            'total' => $pagination->total()
        ];
    }
    public static function store_association($id, $product_id, $cut)
    {
        DB::table('product_promo')->insertOrIgnore([
            'promo_code_id' => $id,
            'product_id' => $product_id,
            'cut' => $cut
        ]);
    }
    public static function update_association($id, $product_id, $cut)
    {
        DB::table('product_promo')->where('promo_code_id', '=', $id)
            ->where('product_id', '=', $product_id)->update(['cut' => $cut]);
    }
    public static function delete_association($id, $product_id)
    {
        DB::table('product_promo')->where('promo_code_id', '=', $id)
            ->where('product_id', '=', $product_id)->delete();
    }
    public static function delete($id)
    {
        DB::table('promo_codes')->where('id', '=', $id)->delete();
    }
    public static function delete_associations($id)
    {
        DB::table('product_promo')->where('promo_code_id', '=', $id)
            ->delete();
    }
}