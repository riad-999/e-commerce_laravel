<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\PromoCode;
use App\Rules\UnusedCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function show()
    {
        if (!session('cart') || !count(session('cart')))
            $cart = null;
        else {
            $cart = Cart::cart(session('cart'), session('promo_code_id'));
        }
        return view('cart', [
            'cart' => $cart,
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
        if ($product->quantity == 0 || $product->deleted)
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
            if ($max == 0) {
                return back()->with([
                    'alert' => (object) [
                        'type' => 'warning',
                        'message' => 'il ne reste aucun exemplaire de la coleur choisi'
                    ]
                ]);
            }
            break;
        }
        if (!$clr)
            return back();
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
    public function order()
    {
        $product_id = request('product_id');
        $color_id = request('color_id');
        $product = Product::get($product_id, true);
        // dd($product_id, $color_id, $product->colors);
        if (!$product)
            return back();
        if ($product->quantity == 0 || $product->deleted)
            return back();
        $cart = session()->get('cart', []);
        $exists = false;
        $max = null;
        $clr = null;
        foreach ($product->colors as $color) {
            if ($color->id != $color_id)
                continue;
            // dd('found');
            $clr = $color;
            $max = $color->quantity;
            if ($max == 0) {
                return back()->with([
                    'alert' => (object) [
                        'type' => 'warning',
                        'message' => 'il ne reste aucun exemplaire de la coleur choisi'
                    ]
                ]);
            }
            break;
        }
        // dd(!$clr);
        if (!$clr)
            return back();
        foreach ($cart as $item) {
            if (
                $item->product_id != $product_id ||
                $item->color_id != $color_id
            )
                continue;
            $exists = true;
            $item->quantity = $item->quantity + 1 > $max ?
                $max : $item->quantity + 1;
            $item->image = $clr->main_image;
            break;
        }
        if (!$exists) {
            array_unshift($cart, (object)[
                'product_id' => $product_id,
                'color_id' => $color_id,
                'quantity' => 1,
                'image' => $clr->main_image,
                'name' => $product->name,
                'price' => $product->price,
                'promo' => $product->promo
            ]);
        }
        session()->put('cart', $cart);
        return redirect(route('cart'));
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
            if ($item->promo) {
                if (($item->cut && ($item->cut * $item->price / 100) < $item->promo)) {
                    $sum += floor($item->cut * $item->price / 100) * $item->quantity;
                } else {
                    $sum += $item->promo * $item->quantity;
                }
            } elseif ($item->cut) {
                $sum += $item->quantity * $item->promo;
            } else {
                $sum += $item->quantity * $item->price;
            }
        }
        session()->put('cart', $cart);
        return response(['sub_total' => $sum], 200);
    }
    public function apply_promo_code(Request $request)
    {
        if (!session('cart') || !count(session('cart')))
            return back();
        $inputs = $request->validate([
            'code' => [
                'required',
                'exists:promo_codes,code',
                new UnusedCode(Auth::user()->id, request('code'))
            ]
        ]);
        $code = PromoCode::get_by_code($inputs['code']);
        $ids = [];
        foreach (session('cart') as $item) {
            if (!in_array($item->product_id, $ids)) {
                array_push($ids, $item->product_id);
            }
        }
        $exists = DB::table('product_promo')
            ->whereIn('product_id', $ids)
            ->where('promo_code_id', '=', $code->id)->first();
        if (!$exists) {
            session()->flash('warning');
        } else {
            $request->session()->put('promo_code_id', $code->id);
            $request->session()->put('code', $code);
        }
        return redirect(route('cart'))->withFragment('code');
    }
    public function remove_promo_code()
    {
        session()->forget(['code', 'promo_code_id']);
        return back()->withFragment('code');
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
    public function validate_order()
    {
        if (!session('cart'))
            return back();
        $ids = [];
        foreach (session('cart') as $item) {
            array_push($ids, $item->product_id);
        }
        $products = Product::get_by_ids($ids, true);
        $errors = [];
        foreach (session('cart') as $item) {
            foreach ($products as $product) {
                if ($product->id != $item->product_id)
                    continue;
                foreach ($product->colors as $color) {
                    if ($color->color_id != $item->color_id)
                        continue;
                    if ($color->quantity < $item->quantity) {
                        $errors["$item->product_id-$item->color_id"] =
                            "il ne reste que $color->quantity exemplaires de ce produit de cette couleur";
                    }
                    break;
                }
            }
        }
        if (count($errors))
            return back()->withErrors($errors);
        else
            return redirect(route('create-order'));
    }
}