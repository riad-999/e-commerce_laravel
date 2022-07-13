<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Brand
{
    static public function all()
    {
        $brands = DB::table('brands')
            ->get();
        return $brands->first() ? $brands : null;
    }
}