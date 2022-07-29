<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $wilayas = json_decode(
            file_get_contents(
                storage_path() . "/app/wilayas.json"
            )
        );
        $wilayas = collect($wilayas)->map(
            fn ($item) => (object) [
                'name' => "$item->code $item->name",
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
    public function edit($id)
    {
        $wilayas_ = collect(json_decode(
            file_get_contents(
                storage_path() . "/app/wilayas.json"
            )
        ));
        $wilayas = $wilayas_->map(
            fn ($item) => (object) [
                'name' => "$item->code $item->name",
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
            $quantity = $request->input("$product->product_id-$product->order_id");
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
        return redirect()->route('edit-order-products', $order->id);
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