<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Category
{
    static public function all()
    {
        $categories = DB::table('categories')->get();
        return $categories;
    }
    static public function get($id)
    {
        $category = DB::table('categories')
            ->where('id', '=', $id)->get()->first();
        return $category;
    }
    static public function get_all($ids)
    {
        $category = DB::table('categories')
            ->whereIn('id', $ids)->get();
        return $category;
    }
    static public function store($data)
    {
        DB::table('categories')->insert($data);
    }
    static public function update($fields, $id)
    {
        DB::table('categories')->where('id', '=', $id)
            ->update($fields);
    }
    static public function delete($id)
    {
        $exists = DB::table('products')
            ->where('category_id', '=', $id)
            ->where('deleted', '=', 0)->first();
        if ($exists)
            return null;
        DB::table('categories')->where('id', '=', $id)
            ->delete();
        return true;
    }
}