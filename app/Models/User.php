<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function create($data)
    {
        $now = now();
        $atts = ['name', 'email', 'password'];
        $user = [];
        foreach ($atts as $att) {
            $user[$att] = $data[$att];
        }
        $user['created_at'] = $now;
        $user['updated_at'] = $now;
        $user_id = DB::table('users')->insertGetId($user);
        $atts = ['address', 'number', 'wilaya_id'];
        if (count(array_filter($atts))) {
            $address = [];
            foreach ($atts as $att) {
                $address[$att] = $data[$att];
            }
            $address['user_id'] = $user_id;
            DB::table('users_addresses')->insert($address);
        }
    }
    public static function get($ids, $withAddress = true)
    {
        $query = DB::table('users');
        if ($withAddress) {
            $query = $query->leftJoin('users_addresses', 'users.id', '=', 'user_id')
                ->leftJoin('wilayas', 'wilaya_id', '=', 'wilayas.id')
                ->select([
                    'users.id as id', 'users.name as name', 'email',
                    'number', 'address', 'wilayas.name as wilaya',
                    'duration', 'home_shipment as home',
                    'desk_shipment as desk', 'wilayas.id as code'
                ]);
        }
        $query->when(
            is_array($ids) ? $ids : null,
            fn ($query, $ids) => $query->whereIn('users.id', $ids)
        )->when(
            !is_array($ids) ? $ids : null,
            fn ($query, $id) => $query->where('users.id', '=', $id)
        );
        if (is_array($ids)) {
            return $query->get();
        } else {
            return $query->first();
        }
    }
    public static function _update($id, $data)
    {
        $user = self::get($id);
        if (!$user) {
            return;
        }
        DB::table('users')->where('id', '=', $id)->update([
            'email' => $data['email'],
            'name' => $data['name']
        ]);
        $atts = ['number', 'address', 'wilaya_id'];
        $address = [];
        foreach ($atts as $att) {
            $address[$att] = $data[$att];
        }
        if ($user->address || $user->wilaya || $user->number) {
            foreach ($atts as $att) {
                DB::table('users_addresses')
                    ->where('user_id', '=', $id)
                    ->update($address);
            }
        } else {
            $address['user_id'] = $id;
            DB::table('users_addresses')->insert($address);
        }
    }
    public static function simple_update($id, $data)
    {
        DB::table('users')->where('id', '=', $id)->update($data);
    }
    public static function update_password($id, $password)
    {
        DB::table('users')->where('id', '=', $id)
            ->update(['password' => $password]);
    }
    public static function get_by_name($name)
    {
        return DB::table('users')
            ->where('email', '=', $name)
            ->orWhere('name', '=', $name)
            ->first();
    }
    public static function get_by_email($email)
    {
        return DB::table('users')
            ->where('email', '=', $email)
            ->first();
    }
    public static function admins()
    {
        return DB::table('users')
            ->where('is_admin', '=', 1)->get();
    }
    public static function insert($data)
    {
        DB::table('users')->insert($data);
    }
    public static function delete_user($id)
    {
        DB::table('users')->where('id', '=', $id)
            ->delete();
    }
    public static function all_users()
    {
        $pagination = DB::table("users")->select('name', 'email')
            ->paginate(20);
        $curr = $pagination->currentPage();
        $last = $pagination->lastPage();
        return (object)[
            'products' => $pagination->items(),
            'currentPage' => $curr,
            'lastPage' => $last,
            'nextPage' => $curr >= $last ? $last : $curr + 1,
            'previousPage' => $curr <= 1 ? 1 : $curr - 1,
            'total' => $pagination->total()
        ];
    }
    public static function save_product($product_id, $user_id)
    {
        $exists = DB::table('products')
            ->where('id', '=', $product_id)
            ->where('deleted', '=', 0)->first();
        if (!$exists)
            return null;
        DB::table('saves')->insert([
            'product_id' => $product_id,
            'user_id' => $user_id
        ]);
        return true;
    }
    public static function unsave_product($product_id, $user_id)
    {
        $exists = DB::table('products')
            ->where('id', '=', $product_id)
            ->where('deleted', '=', 0)->first();
        if (!$exists)
            return null;
        DB::table('saves')->where('product_id', '=', $product_id)
            ->where('user_id', '=', $user_id)->delete();
        return true;
    }
    public static function saved_products($id)
    {
        return DB::table('saves')
            ->join('products', 'product_id', '=', 'products.id')
            ->select(['id', 'name', 'price', 'promo'])
            ->selectRaw('(select main_image from color_product where products.id = color_product.product_id limit 1) as image')
            ->where('user_id', '=', $id)->get();
    }
    public static function products_to_review($id)
    {
        return DB::table('orders')
            ->join('order_product_color', 'orders.id', '=', 'order_product_color.order_id')
            ->join('products', 'order_product_color.product_id', '=', 'products.id')
            ->leftJoin('reviews', function ($join) {
                $join->on('products.id', '=', 'reviews.product_id');
                $join->on('orders.user_id', '=', 'reviews.user_id');
            })
            // ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
            ->select(['products.id', 'products.name'])
            ->selectRaw('max(orders.created_at) as latest_order')
            ->selectRaw('(select main_image from color_product where products.id = color_product.product_id limit 1) as image')
            ->where('orders.user_id', '=', $id)
            ->whereNull('reviews.product_id')
            ->groupBy(['products.id', 'products.name', 'image'])->orderByDesc('latest_order')->get();
    }
    public static function insert_review($data)
    {
        $exists = DB::table('products')
            ->where('id', '=', $data['product_id'])
            ->where('deleted', '=', 0)->first();
        if (!$exists)
            return;
        DB::table('reviews')->insert($data);
    }
    public static function update_review($product_id, $user_id, $data)
    {
        DB::table('reviews')->where('product_id', '=', $product_id)
            ->where('user_id', '=', $user_id)->update($data);
    }
}