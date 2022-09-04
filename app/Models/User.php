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
                    'duration','home_shipment as home', 
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
}