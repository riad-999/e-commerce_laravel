<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Wilaya
{
    public static function all()
    {
        return DB::table('wilayas')->orderBy('id')->get();
    }
    public static function get_by_name($name)
    {
        return DB::table('wilayas')
            ->where('name', '=', $name)->first();
    }
    public static function get($id)
    {
        return DB::table('wilayas')
            ->where('id', '=', $id)->first();
    }
    public static function insert($data)
    {
        DB::table('wilayas')->insert($data);
    }
    public static function update($id, $data)
    {
        DB::table('wilayas')
            ->where('id', '=', $id)
            ->update($data);
    }
    public static function delete($id)
    {
        $exists = DB::table('orders')
            ->where('wilaya_id', '=', $id)->first();
        if ($exists)
            return false;
        DB::table('wilayas')->where('id', '=', $id)
            ->delete();
        return true;
    }
}