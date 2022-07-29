<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Color
{
    static public function all($request = null)
    {
        $colors = DB::table('colors')
            ->when($request ? $request->input('name') : null, function ($query, $name) {
                $query->where('name', 'like', "%$name%");
            })
            ->get();
        return $colors;
    }
    static public function get($id)
    {
        $color = DB::table('colors')
            ->where('id', '=', $id)->get()->first();
        return $color;
    }
    static public function store($data)
    {
        DB::table('colors')->insert($data);
    }
    static public function update($fields, $id)
    {
        DB::table('colors')->where('id', '=', $id)
            ->update($fields);
    }
    static public function delete($id)
    {
        DB::table('colors')->where('id', '=', $id)
            ->delete();
    }
}