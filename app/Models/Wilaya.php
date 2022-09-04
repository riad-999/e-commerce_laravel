<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Wilaya
{
    public static function all()
    {
        return DB::table('wilayas')->get();
    }
    public static function get_by_name($name)
    {
        return DB::table('wilayas')
            ->where('name','=',$name)->first();
    }
}