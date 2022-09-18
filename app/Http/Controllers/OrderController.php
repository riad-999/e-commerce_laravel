<?php

namespace App\Http\Controllers;

use App\Mail\Order as MailOrder;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Wilaya;
use App\Rules\PhoneNumber;
use App\Rules\ShipmentType;
use App\Rules\Wilaya as RulesWilaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $wilayas = Wilaya::all();
        $wilayas = collect($wilayas)->map(
            fn ($item) => (object) [
                'name' => "$item->id $item->name",
                'value' => $item->name
            ]
        );
        $states = collect(['en traitment', 'en route', 'livré', 'tous'])
            ->map(fn ($item) => (object)[
                'name' => $item,
                'value' => $item
            ]);
        $pagination = Order::all($request);
        $query = $request->query();
        $query['page'] = $pagination->nextPage;
        $nextUrl = $request->fullUrlWithQuery($query);
        $query['page'] = $pagination->previousPage;
        $prevUrl = $request->fullUrlWithQuery($query);
        return view('admin.orders', [
            'wilayas' => $wilayas,
            'states' => $states,
            'orders' => $pagination->orders,
            'currentPage' => $pagination->currentPage,
            'lastPage' => $pagination->lastPage,
            'nextUrl' => $nextUrl,
            'prevUrl' => $prevUrl,
            'id' => $request->input('id'),
            'name' => $request->input('name'),
            'wilaya' => $request->input('wilaya'),
            'state' => $request->input('state'),
            'date' => $request->input('date')
        ]);
    }
    public function show($id)
    {
        $order = Order::getOrderWithDetails($id);
        if (!$order)
            return redirect('/404');
        $states = collect(['en traitment', 'en route', 'livré', 'tous'])
            ->map(fn ($item) => (object)[
                'name' => $item,
                'value' => $item
            ]);
        if (!$order)
            return redirect('/404');
        return view('admin.show-order', [
            'order' => $order,
            'states' => $states
        ]);
    }
    public function create()
    {
        if (!session('cart') || !count(session('cart')))
            return redirect(route('cart'));
        $default_wilaya = null;
        $old_wilaya = null;
        $default_type = 'à domicile';
        $old_wilaya_str = old('wilaya');
        $old_type = old('shipment_type');
        $wilayas_ = Wilaya::all();
        foreach ($wilayas_ as $item) {
            $item->home = $item->home_shipment;
            $item->desk = $item->desk_shipment;
            if ($item->id == 16)
                $default_wilaya = $item;
            if ($old_wilaya_str && $old_wilaya_str == $item->name)
                $old_wilaya = $item;
        }

        $wilayas = $wilayas_->map(fn ($item) => (object) [
            'name' => "$item->id $item->name",
            'value' => $item->name
        ]);
        $shipment_types = collect(['à domicile', 'au bureau'])->map(
            fn ($item) => (object) [
                'name' => $item,
                'value' => $item,
            ]
        );
        $user = null;
        if ($old_wilaya) {
            $wilaya = $old_wilaya;
        } elseif (Auth::check()) {
            $user = User::get(Auth::user()->id, true);
            if (!$user->wilaya)
                $wilaya = $default_wilaya;
            else
                $wilaya = (object) [
                    'id' => $user->code,
                    'name' => $user->wilaya,
                    'duration' => $user->duration,
                    'desk' => $user->desk,
                    'home' => $user->home
                ];
        } else {
            $wilaya = $default_wilaya;
        }
        $sum = 0;
        foreach (session('cart') as $item) {
            if ($item->promo) {
                if (($item->cut && ($item->cut * $item->price / 100) < $item->promo)) {
                    $sum += floor($item->cut * $item->price / 100) * $item->quantity;
                } else {
                    $sum += $item->promo * $item->quantity;
                }
            } elseif ($item->cut) {
                $sum += $item->quantity * floor($item->cut * $item->price / 100);
            } else {
                $sum += $item->quantity * $item->price;
            }
        }
        return view('admin.create-order', [
            'wilayas' => $wilayas,
            'wilayas_' => $wilayas_,
            'shipment_types' => $shipment_types,
            'default_wilaya' => $default_wilaya,
            'old_wilaya' => $old_wilaya,
            'default_type' => $default_type,
            'old_type' => $old_type,
            'wilaya' => $wilaya,
            'user' => $user,
            'sub_total' => $sum
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'address' => ['required'],
            'number' => ['required', new PhoneNumber],
            'wilaya' => [new RulesWilaya],
            'shipment_type' => ['required', new ShipmentType]
        ]);

        if (!session('cart'))
            return redirect(route('cart'));
        // check quantities
        $ids = [];
        foreach (session('cart') as $item) {
            if (!in_array($item->product_id, $ids))
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
            return redirect(route('cart'))->withErrors($errors);
        // check if session data is up to date (promo, price and deleted)
        foreach (session('cart') as $item) {
            foreach ($products as $product) {
                if ($item->product_id != $product->id)
                    continue;
                if (
                    $item->price != $product->price ||
                    $item->promo != $product->promo ||
                    $product->deleted
                ) {
                    return redirect(route('cart'))->with([
                        'alert' => (object)[
                            'type' => 'warning',
                            'message' => "votre panier n'est pas à jour, il faut refaire la commande."
                        ]
                    ]);
                }
            }
        }
        // check if promo code data is depricated
        if (session('code')) {
            // if (now()->format('Y-m-d') >= session('code')->expires)
            //     return redirect()->with([
            //         'alert' => (object)[
            //             'type' => 'warning',
            //             'message' => "le code promo vien d'expirer, il faut refaire la commande."
            //         ]
            //     ]);
            $products_cut = Product::get_products_with_cut($ids, session('promo_code_id'));
            foreach (session('cart') as $item) {
                foreach ($products_cut as $product) {
                    if ($product->id != $item->product_id)
                        continue;
                    if ($product->cut != $item->cut)
                        return redirect(route('cart'))->with([
                            'alert' => (object)[
                                'type' => 'warning',
                                'message' => "votre panier n'est pas à jour, il faut refaire la commande."
                            ]
                        ]);
                }
            }
        }
        $data = [];
        $wilaya = Wilaya::get_by_name(request()->input('wilaya'));
        if (!$wilaya)
            return back();
        $inputs = ['name', 'email', 'number', 'shipment_type', 'address', 'note'];
        foreach ($inputs as $input) {
            $data[$input] = request()->input($input);
        }
        $data['state'] = 'en traitment';
        $data['shipment'] = $data['shipment_type'] == 'à domicile'
            ? $wilaya->home_shipment : $wilaya->desk_shipment;
        $data['wilaya_id'] = $wilaya->id;
        if (Auth::check())
            $data['user_id'] = Auth::user()->id;
        $id = Order::insert($data);
        Order::associate($id, session('cart'));
        if (Auth::check() && session('code'))
            User::use_promo_code(session('promo_code_id'), Auth::user()->id);
        $admins = User::admins();
        foreach ($admins as $admin) {
            Mail::to($admin->email)
                ->send(new MailOrder(session('cart'), true, (object)$data, $wilaya));
        }
        Mail::to($data['email'])
            ->send(new MailOrder(session('cart'), false, (object)$data, $wilaya));
        session()->forget(['code', 'promo_code_id']);
        session()->put('cart', []);
        return redirect(route('home'))->with([
            'alert' => (object)[
                'type' => 'success',
                'message' => 'votre commande a été bien enregistrée, 
                nous vous appellerons pour la confirmation'
            ]
        ]);
    }
    public function edit($id)
    {
        $wilayas_ = Wilaya::all()->map(function ($item) {
            $item->home = $item->home_shipment;
            $item->desk = $item->desk_shipment;
            return $item;
        });
        $wilayas = $wilayas_->map(
            fn ($item) => (object) [
                'name' => "$item->id $item->name",
                'value' => $item->name
            ]
        );
        $shipment_types = collect(['à domicile', 'au bureau'])->map(
            fn ($item) => (object) [
                'name' => $item,
                'value' => $item
            ]
        );
        $order = Order::get($id);
        $states = collect(['en traitment', 'en route', 'livré', 'tous'])
            ->map(fn ($item) => (object)[
                'name' => $item,
                'value' => $item
            ]);
        $desk = true;
        foreach ($wilayas_ as $wilaya) {
            if ($wilaya->name == $order->wilaya && !$wilaya->desk) {
                $desk = false;
                break;
            }
        }
        if (!$order)
            return redirect('/404');
        return view('admin.edit-order', [
            'order' => $order,
            'states' => $states,
            'wilayas' => $wilayas,
            'shipment_types' => $shipment_types,
            'wilayas_' => $wilayas_,
            'desk' => $desk
        ]);
    }
    public function edit_products($id)
    {
        $order = Order::getOrderWithDetails($id);
        return view('admin.edit-order-products', [
            'order' => $order
        ]);
    }
    public function update(Request $request, $id)
    {
        $order = Order::getOrderWithDetails($id);
        if (!$order) {
            return redirect('/404');
        }
        if ($state = $request->input('state')) {
            if ($request->input('cancel')) {
                $data = ['state' => $state];
                if ($state == 'en traitment')
                    $data['track_code'] = null;
                Order::update($id, $data);
            } else {
                if ($state == 'en route') {
                    //check if quantities are valid
                    $obj = self::checkQuantities($order);
                    if (!$obj->valid) {
                        return back()->with([
                            'alert' => (object)[
                                'type' => 'error',
                                'message' => $obj->errors
                            ]
                        ]);
                    }
                }
                $data = ['state' => $state];
                if ($tmp = $request->input('track_code'))
                    $data['track_code'] = $tmp;
                Order::update($id, $data);
            }
            return back()->with([
                'alert' => (object)[
                    'type' => 'success',
                    'message' => "la commande est $state"
                ]
            ]);
        } else {
            $inputs = ['address', 'wilaya', 'shipment_type', 'name', 'track_code', 'note'];
            $request->validate([
                'address' => ['required'],
                'wilaya' => ['required'],
                'shipment_type' => ['required'],
                'name' => ['required'],
            ]);
            $data = [];
            foreach ($inputs as $input) {
                $data[$input] = $request->input($input);
            }
            Order::update($id, $data);
            return back()->with([
                'alert' => (object)[
                    'type' => 'success',
                    'message' => "la commande est modifié"
                ]
            ]);
        }
    }
    public function update_products(Request $request, $id)
    {
        $order = Order::getOrderWithDetails($id);
        $errors = [];
        $data = [];
        foreach ($order->products as $product) {
            if ($product->quantity == 0) {
                return back()->withErrors([
                    "$product->product_id-$product->order_id" => "la quantité ne doit pas ètre 0"
                ]);
            }
            $quantity = $request->input("$product->product_id-$product->color_id");
            if ($quantity > $product->pcquantity)
                array_push($errors, "il rest juste $product->pcquantity du $product->pname");
            array_push($data, (object) [
                'product_id' => $product->product_id,
                'color_id' => $product->color_id,
                'quantity' => $quantity
            ]);
        }
        if (count($errors))
            return back()->with([
                'alert' => (object)[
                    'type' => 'error',
                    'message' => $errors
                ]
            ])->withInput();
        Order::update_products($order->id, $data);
        return redirect()->back()->with([
            'alert' => (object)[
                'type' => 'success',
                'message' => "la commande est modifié"
            ]
        ]);;
    }
    public function delete($id)
    {
        Order::delete($id);
        return back()->with([
            'alert' => (object)[
                'type' => 'success',
                'message' => "la commande est supprimé"
            ]
        ]);
    }
    public function delete_product($id, $product_id, $color_id)
    {
        Order::delete_product($id, $product_id, $color_id);
        return back()->with([
            'alert' => (object)[
                'type' => 'success',
                'message' => "produit supprimé"
            ]
        ]);
    }
    private function checkQuantities($order)
    {
        $valid = true;
        $errors = [];
        foreach ($order->products as $product) {
            if ($product->quantity > $product->pcquantity) {
                $valid = false;
                array_push(
                    $errors,
                    "imposible de commander $product->quantity 
                    du produit $product->pname de la coluer $product->cname 
                    il reste $product->pcquantity"
                );
            }
        }
        return (object)['valid' => $valid, 'errors' => $errors];
    }
}