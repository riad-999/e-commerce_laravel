<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Wilaya;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        $wilayas = Wilaya::all()->map(
            fn ($item) => (object) [
                'name' => "$item->id $item->name",
                'value' => $item->name
            ]
        );
        return view('register', [
            'wilayas' => $wilayas
        ]);
    }
    public function register(Request $request)
    {
        $creds = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:6'],
            'number' => [new PhoneNumber]
        ]);
        $wilayas = Wilaya::all();
        if ($request->input('wilaya')) {
            $exists = false;
            foreach ($wilayas as $item) {
                if ($item->name == $request->input('wilaya')) {
                    $exists = true;
                    $creds['wilaya'] = $item->id;
                    break;
                }
            }
            if (!$exists)
                return back();
        }
        $data = [
            'name' => $creds['name'],
            'email' => $creds['email'],
            'password' => Hash::make(($creds['password'])),
            'wilaya_id' => $creds['wilaya'],
            'number' => $request->input('number'),
            'address' => $request->input('address')
        ];
        User::create($data);
        return redirect(route('show-login'))->with(['registered' => true]);
    }
    public function show()
    {
        $user = User::get(Auth::user()->id);
        if (!$user)
            return redirect('/404');
        return view('profile', [
            'user' => $user
        ]);
    }
    public function edit()
    {
        $wilayas = Wilaya::all();
        $wilayas = collect($wilayas)->map(
            fn ($item) => (object) [
                'name' => "$item->id $item->name",
                'value' => $item->name
            ]
        );
        $user = User::get(Auth::user()->id);
        if (!$user)
            return redirect('/404');
        return view('edit-profile', [
            'user' => $user,
            'wilayas' => $wilayas
        ]);
    }
    public function update(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'number' => [new PhoneNumber]
        ]);
        $wilayas = Wilaya::all();
        $data = $request->all();
        if ($request->input('wilaya')) {
            $exists = false;
            $data['wilaya_id'] = null;
            foreach ($wilayas as $item) {
                if ($item->name == $request->input('wilaya')) {
                    $exists = true;
                    unset($data['wilaya']);
                    $data['wilaya_id'] = $item->id;
                    break;
                }
            }
            if (!$exists)
                return back();
            User::_update($id, $data);
            return back();
        }
    }
    public function show_check_password()
    {
        return view('check-password', [
            'id' => Auth::user()->id
        ]);
    }
    public function check_password(Request $request)
    {
        $request->validate(['password' => ['required']]);
        $user = Auth::user();
        if (Hash::check($request->input('password'), $user->password)) {
            return redirect(route('edit-password'));
        } else {
            return back()->withErrors(['password' => "ce mot de pass n'est pas le votre"]);
        }
    }
    public function edit_password()
    {
        return view('edit-password', [
            'id' => Auth::user()->id
        ]);
    }
    public function update_password(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:6'],
        ]);
        $id = Auth::user()->id;
        User::update_password($id, Hash::make($request->input('password')));
        return redirect(route('profile', $id))->with([
            'alert' => (object) [
                'type' => 'success',
                'message' => 'votre mot de pass a été changé'
            ]
        ]);
    }
    public function orders()
    {
        $user = Auth::user();
        $orders = Order::userOrders($user->id);
        return view('user-orders', [
            'user' => $user,
            'orders' => $orders
        ]);
    }
    public function show_order($id)
    {
        if (!$order = Order::getOrderWithDetails($id))
            return redirect('/404');
        $states = collect(['en traitment', 'en route', 'livré', 'tous'])
            ->map(fn ($item) => (object)[
                'name' => $item,
                'value' => $item
            ]);
        return view('user-order', [
            'order' => Order::getOrderWithDetails($id),
            'states' => $states,
            'user' => Auth::user()
        ]);
    }
}