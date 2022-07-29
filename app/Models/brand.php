<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Brand
{
    static public function all()
    {
        $brands = DB::table('brands')
            ->get();
        return $brands;
    }
    static public function get($id)
    {
        $brand = DB::table('brands')
            ->where('id', '=', $id)->get()->first();
        return $brand;
    }
    static public function store($data)
    {
        DB::table('brands')->insert($data);
    }
    static public function update($fields, $id)
    {
        DB::table('brands')->where('id', '=', $id)
            ->update($fields);
    }
    static public function delete($id)
    {
        DB::table('brands')->where('id', '=', $id)
            ->delete();
    }
}