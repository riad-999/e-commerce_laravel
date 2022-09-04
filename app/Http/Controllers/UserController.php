<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wilaya;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
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
        $wilayas = Wilaya::all([
            'id as code', 'name',
            'home_shipment as home',
            'desk_shipment as desk',
            'duration'
        ]);
        if ($request->input('wilaya')) {
            $exists = false;
            foreach ($wilayas as $item) {
                if ($item->name == $request->input('wilaya')) {
                    $exists = true;
                    $creds['wilaya'] = $item->code;
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
    public function show($id)
    {
        $user = User::get($id);
        if (!$user)
            return redirect('/404');
        return view('profile', [
            'user' => $user
        ]);
    }
    public function edit($id)
    {
        $wilayas = Wilaya::all([
            'id as code', 'name',
            'home_shipment as home',
            'desk_shipment as desk',
            'duration'
        ]);
        $wilayas = collect($wilayas)->map(
            fn ($item) => (object) [
                'name' => "$item->code $item->name",
                'value' => $item->name
            ]
        );
        $user = User::get($id);
        if (!$user)
            return redirect('/404');
        return view('edit-profile', [
            'user' => $user,
            'wilayas' => $wilayas
        ]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'number' => [new PhoneNumber]
        ]);
        $wilayas = Wilaya::all([
            'id as code', 'name',
            'home_shipment as home',
            'desk_shipment as desk',
            'duration'
        ]);
        $data = $request->all();
        if ($request->input('wilaya')) {
            $exists = false;
            $data['wilaya_id'] = null;
            foreach ($wilayas as $item) {
                if ($item->name == $request->input('wilaya')) {
                    $exists = true;
                    unset($data['wilaya']);
                    $data['wilaya_id'] = $item->code;
                    break;
                }
            }
            if (!$exists)
                return back();
            User::_update($id, $data);
            return back();
        }
    }
    public function show_check_password($id)
    {
        return view('check-password', ['id' => $id]);
    }
    public function check_password(Request $request, $id)
    {
        $request->validate(['password' => ['required']]);
        $user = User::get($id, false);
        if (Hash::check($request->input('password'), $user->password)) {
            return redirect(route('edit-password', $user->id));
        } else {
            return back()->withErrors(['password' => "ce mot de pass n'est pas le votre"]);
        }
    }
    public function edit_password($id)
    {
        return view('edit-password', ['id' => $id]);
    }
    public function update_password(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:6'],
        ]);
        User::update_password($id, Hash::make($request->input('password')));
        return redirect(route('profile', $id))->with([
            'alert' => (object) [
                'type' => 'success',
                'message' => 'votre mot de pass a été changé'
            ]
        ]);
    }
}