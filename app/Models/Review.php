<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Review
{
    static public function get($productId, $request = null)
    {
        $id = null;
        $userName = null;

        $query = DB::table('reviews')
            ->join('users', 'user_id', '=', 'users.id')
            ->select([
                'users.name', 'reviews.id', 'score', 'feedback',
                'reviews.created_at as date',
            ])->whereNotNull('feedback');
        if ($id) {
            $reviews = $query->where('reviews.id', '=', $productId)->get();
            return $reviews;
        }
        $reviews = $query->where('product_id', '=', $productId)
            ->when($userName, function ($query, $userName) {
                $query->where('name', 'like', "%$userName%");
            })->get();

        return $reviews->first() ? $reviews : null;
    }
    static public function filter($productId, $score)
    {
        $reviews = DB::table('reviews')
            ->join('users', 'user_id', '=', 'users.id')
            ->select([
                'users.name', 'reviews.id', 'score', 'feedback',
                'reviews.created_at as date',
            ])->whereNotNull('feedback')
            ->where('product_id', '=', $productId)
            ->where('score', '=', $score)->get();

        return $reviews->first() ? $reviews : null;
    }
}