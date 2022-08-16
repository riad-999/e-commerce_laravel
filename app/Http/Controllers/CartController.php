<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show()
    {
        if (!session('cart') || !count(session('cart')))
            $cart = null;
        else {
            $cart = Cart::cart(session('cart'));
        }
        return view('cart', [
            'cart' => $cart
        ]);
    }
    public function add(Request $request)
    {
        $color_id = $request->input('color_id');
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');
        $product = Product::get($product_id, true);
        if (!$product)
            return back();
        $cart = $request->session()->get('cart', []);
        $exists = false;
        $max = null;
        $clr = null;

        foreach ($product->colors as $color) {
            if ($color->id != $color_id)
                continue;
            $clr = $color;
            $max = $color->quantity;
        }

        foreach ($cart as $item) {
            if (
                $item->product_id != $product_id ||
                $item->color_id != $color_id
            )
                continue;
            $exists = true;
            $item->quantity = $item->quantity + $quantity > $max ?
                $max : $item->quantity + $quantity;
            $item->image = $clr->main_image;
        }
        if (!$exists) {
            $quantity = $quantity > $max ? $max : $quantity;
            array_unshift($cart, (object)[
                'product_id' => $product_id,
                'color_id' => $color_id,
                'quantity' => $quantity,
                'image' => $clr->main_image,
                'name' => $product->name,
                'price' => $product->price,
                'promo' => $product->promo
            ]);
        }
        $request->session()->put('cart', $cart);
        return back()->with([
            'side-cart' => true
        ]);
    }
    public function update_item_quantity(Request $request)
    {
        if (!session('cart'))
            return response(['refresh' => true]);
        $cart = session('cart');
        $sum = 0;
        foreach ($cart as $item) {
            if (
                $item->product_id == $request->all()['product_id'] &&
                $item->color_id == $request->all()['color_id']
            ) {
                $item->quantity = $request->all()['quantity'];
            }
            if ($item->promo)
                $sum += $item->quantity * $item->promo;
            else
                $sum += $item->quantity * $item->price;
        }
        session()->put('cart', $cart);
        return response(['sub_total' => $sum], 200);
    }
    public function delete_item(Request $request)
    {
        if (!session('cart')) {
            return back();
        }
        $cart = session('cart');
        $new_cart = [];
        foreach ($cart as $item) {
            if (
                $item->product_id != $request->all()['product_id'] ||
                $item->color_id != $request->all()['color_id']
            )   array_push($new_cart, $item);
        }
        session()->put('cart', $new_cart);
        return back();
    }
}