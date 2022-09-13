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
            'name' => ['required', 'unique:users,name'],
            'email' => ['required', 'email', 'unique:users,email'],
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
            'name' => ['required', "unique:users,name,$id"],
            'email' => ['required', 'email', "unique:users,email,$id"],
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
    public function admins()
    {
        return view('admin.admins', [
            'admins' => User::admins()
        ]);
    }
    public function store_admin()
    {
        request()->validate([
            'name' => ['required', 'unique:users,name'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6']
        ]);
        User::insert([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'is_admin' => true
        ]);
        return back()->with([
            'alert' => (object) [
                'type' => 'success',
                'message' => "l'admin a été ajouté"
            ]
        ]);
    }
    public function delete($id)
    {
        User::delete_user($id);
        return back()->with([
            'alert' => (object) [
                'type' => 'success',
                'message' => "l'admin a été supprimé"
            ]
        ]);
    }
    public function index()
    {
        $paginatation = User::all_users();
        $query = request()->query();
        $query['page'] = $paginatation->nextPage;
        $nextUrl = request()->fullUrlWithQuery($query);
        $query['page'] = $paginatation->previousPage;
        $prevUrl = request()->fullUrlWithQuery($query);
        return view('admin.users', [
            'users' => $paginatation->products,
            'currentPage' => $paginatation->currentPage,
            'lastPage' => $paginatation->lastPage,
            'nextUrl' => $nextUrl,
            'prevUrl' => $prevUrl,
        ]);
    }
    public function save_product()
    {
        $state = request()->all()['state'];
        $product_id = request()->all()['product_id'];
        if ($state == 'saved') {
            if (User::unsave_product($product_id, Auth::user()->id))
                return response(status: 200);
            else
                return response('not found', 404);
        } elseif ($state == 'unsaved') {
            User::save_product($product_id, Auth::user()->id);
            return response(status: 201);
        } else
            return response('not found', 404);
    }
    public function saved_products()
    {
        $user = Auth::user();
        return view('admin.saves', [
            'user' => $user,
            'products' => User::saved_products($user->id)
        ]);
    }
    public function pending_reviews()
    {
        $user = Auth::user();
        return view('wait-for-review', [
            'user' => $user,
            'products' => User::products_to_review($user->id)
        ]);
    }
    public function store_review($id)
    {
        request()->validate([
            'feedback' => ['max:65535']
        ]);
        $user_id = Auth::user()->id;
        User::insert_review([
            'product_id' => $id,
            'user_id' => $user_id,
            'score' => request()->input('score'),
            'feedback' => request()->input('feedback'),
            'created_at' => now()
        ]);
        return back()->with([
            'alert' => (object) [
                'type' => 'success',
                'message' => 'votre feedback a été bien enregistré, merci'
            ]
        ]);
    }
    public function delete_feedback($product_id, $user_id)
    {
        User::update_review($product_id, $user_id, ['feedback' => null]);
        return back()->with([
            'alert' => (object) [
                'type' => 'success',
                'message' => 'le commentaire a été supprimé'
            ]
        ]);
    }
}