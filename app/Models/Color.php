<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Color
{
    static public function all()
    {

        $colors = DB::table('colors')
            ->get();
        return $colors->first() ? $colors : null;
    }
}