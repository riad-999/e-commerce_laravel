<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Category
{
    static public function all()
    {
        $categories = DB::table('categories')->get();
        return $categories->first() ? $categories : null;
    }
}