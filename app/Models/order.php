<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Order
{
    static private function addProductsToOrders($orders)
    {
        $orders_ids = $orders->map(fn ($order) => $order->id);
        // get all product-color combinations for each order.
        $products_colors = DB::table('order_product_color')
            ->join('colors', 'color_id', '=', 'colors.id')
            ->join('products', 'product_id', '=', 'products.id')
            ->join('color_product', function ($join) {
                $join->on('order_product_color.product_id', '=', 'color_product.product_id');
                $join->on('order_product_color.color_id', '=', 'color_product.color_id');
            })
            ->select([
                'order_id', 'order_product_color.product_id', 'order_product_color.color_id',
                'products.name as pname', 'color_product.quantity as pcquantity', 'order_product_color.price', 'colors.name as cname',
                'order_product_color.quantity', 'total', 'main_image'
            ])
            ->whereIn('order_id', $orders_ids)->get();
        // dd($products_colors);
        // associating each order with product-color combinations.
        foreach ($orders as $order) {
            $order->products = [];
            foreach ($products_colors as $record) {
                // if it doesn't belong to the order go to the next record.
                if ($record->order_id != $order->id)
                    continue;
                array_push($order->products, $record);
            }
        }
        return $orders;
    }

    static public function all($request)
    {
        if ($id = $request->input('id'))
            return
                DB::table('orders')
                ->where('id', '=', $id)->get();

        $pagination = DB::table('orders')
            ->when($request->input('name'), function ($query, $name) {
                $query->where('name', 'like', "%$name%");
            })
            ->when($request->input('state'), function ($query, $state) {
                if ($state != 'tous')
                    $query->where('state', '=', $state);
            })
            ->when(!$request->input('state'), function ($query) {
                $query->where('state', '=', 'en traitment');
            })
            ->when($request->input('wilaya'), function ($query, $wilaya) {
                $query->where('wilaya', '=', $wilaya);
            })
            ->when($request->input('date'), function ($query, $date) {
                $query->whereDate('created_at', '=', $date);
            })
            ->orderByDesc('id')->paginate(20);

        $currentPage = $pagination->currentPage();
        $lastPage = $pagination->lastPage();
        return (object)[
            'orders' => collect($pagination->items()),
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
            'nextPage' => $currentPage >= $lastPage ? $lastPage : $currentPage + 1,
            'previousPage' => $currentPage <= 1 ? 1 : $currentPage - 1
        ];
    }

    static public function get($id)
    {
        $order = DB::table('orders')
            ->where('id', '=', $id)->get()->first();
        return $order;
    }

    static public function getOrderWithDetails($id)
    {
        $orders = DB::table('orders')
            ->where('id', '=', $id)->get();
        if (!$orders->first())
            return null;
        $order = self::addProductsToOrders($orders)
            ->first();
        return $order;
    }

    static public function userOrders($id)
    {
        // get all orders by the user id.
        $orders = DB::table('orders')
            ->where('user_id', '=', $id)
            ->orderByDesc('id')->get();
        $orders = self::addProductsToOrders($orders);
        return $orders; {
            // associating products to each order.
            // assuming initialy the product doesn't exits in the order.
            // $exists = false;
            // foreach ($order->products as $product) {
            //     if ($product->id != $record->product_id)
            //         continue;
            //     $exists = true;
            //     // product exits => append the color.
            //     $color = (object) [
            //         "name" => $record->cname,
            //         "quanity" => $record->quantity,
            //         'total' => $record->total
            //     ];
            //     array_push($product->colors, $color);
            //     break;
            // }
            // // if product not exists in the list append it
            // if (!$exists) {
            //     $item =
            //         (object) [
            //             "id" => $record->product_id,
            //             "name" => $record->pname,
            //             "colors" => [
            //                 (object) [
            //                     "name" => $record->cname,
            //                     "quanity" => $record->quantity,
            //                     'total' => $record->total
            //                 ]
            //             ]
            //         ];
            //     array_push($order->products, $item);
            // }
        }
    }
    public static function update_products($id, $products)
    {
        foreach ($products as $product) {
            DB::table('order_product_color')
                ->where('order_id', '=', $id)
                ->where('product_id', '=', $product->product_id)
                ->where('color_id', '=', $product->color_id)
                ->update(['quantity' => $product->quantity]);
        }
    }
    public static function update($id, $data)
    {
        DB::table('orders')
            ->where('id', '=', $id)
            ->update($data);
    }
    public static function delete($id)
    {
        DB::table('orders')->where('id', '=', $id)
            ->delete();
    }
    public static function delete_product($id, $product_id, $color_id)
    {
        DB::table('order_product_color')
            ->where('order_id', '=', $id)
            ->where('product_id', '=', $product_id)
            ->where('color_id', '=', $color_id)
            ->delete();
    }
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // public function products()
    // {
    //     return $this->belongsToMany(Product::class);
    // }
}