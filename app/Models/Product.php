<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Product
{
    private static $page_count = 24;
    public static function all($request)
    {
        $currentPage = 1;
        $lastPage = 1;
        $nextPage = 1;
        $previousPage = 1;
        $total = 0;
        if (($id = $request->input('id'))) {
            $products = DB::table('products')
                ->join('brands', 'brand_id', '=', 'brands.id')
                ->join('categories', 'category_id', '=', 'categories.id')
                ->select(['products.*', 'brands.name as brand', 'categories.name as category'])
                ->where('deleted', '=', 0)
                ->where('products.id', '=', $id)
                ->orderByDesc('products.id')->get();
        } else {
            $pagination = DB::table('products')
                ->join('brands', 'brand_id', '=', 'brands.id')
                ->join('categories', 'category_id', '=', 'categories.id')
                ->select(['products.*', 'brands.name as brand', 'categories.name as category'])
                ->where('products.deleted', '=', 0)
                ->when($request->input('name'), function ($query, $name) {
                    $query->where('products.name', 'like', "%$name%");
                })
                ->when($request->has('promo'), function ($query) {
                    $query->whereNotNull('promo');
                })
                ->orderByDesc('products.id')->paginate(24);
            $currentPage = $pagination->currentPage();
            $lastPage = $pagination->lastPage();
            $nextPage = $currentPage >= $lastPage ? $lastPage : $currentPage + 1;
            $previousPage = $currentPage <= 1 ? 1 : $currentPage - 1;
            $products = collect($pagination->items());
            $total = $pagination->total();
        }
        // getting products colors.
        $ids = [];
        foreach ($products as $product) {
            array_push($ids, $product->id);
        }
        $colors = DB::table('color_product')
            ->whereIn('product_id', $ids)->get();
        // associating each product with its colors
        $products = $products->map(function ($product) use ($colors) {
            $product->colors = [];
            foreach ($colors as $color) {
                if ($product->id == $color->product_id)
                    array_push($product->colors, $color);
            }
            return $product;
        });
        return (object)[
            'products' => $products,
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
            'nextPage' => $nextPage,
            'previousPage' => $previousPage,
            'total' => $total
        ];
    }
    public static function index($request, $order)
    {
        $currentPage = 1;
        $lastPage = 1;
        $nextPage = 1;
        $previousPage = 1;
        $total = 0;
        $brands = $request->input('brands');
        $categories = $request->input('categories');
        $pagination = null;
        $query = DB::table('products')
            ->join('brands', 'brand_id', '=', 'brands.id')
            ->join('categories', 'category_id', '=', 'categories.id')
            ->join('color_product', 'product_id', '=', 'products.id')
            ->select(['products.*', 'brands.name as brand', 'categories.name as category'])
            ->selectRaw('sum(quantity) as sum')
            ->where('products.deleted', '=', 0)
            ->when($request->input('search'), function ($query, $search) {
                $query->where('products.name', 'like', "%$search%")
                    ->orWhere('products.description', 'like', "%$search%");
            })
            ->when(($categories && count(json_decode($categories)) ? json_decode($categories) : null),
                function ($query, $cats) {
                    $query->whereIn('category_id', $cats);
                }
            )
            ->when(($brands && count(json_decode($brands)) ? json_decode($brands) : null),
                function ($query, $brands) {
                    $query->whereIn('brand_id', $brands);
                }
            )
            ->when($request->has('promo'), function ($query) {
                $query->whereNotNull('promo');
            })
            ->when(
                $request->input('price') &&
                    $request->input('price') != '0' ? $request->input('price') : null,
                function ($query, $price) use ($request) {
                    if ($request->has('promo')) {
                        $query->where('promo', '<=', $price);
                    } else {
                        $query->where(function ($query) use ($price) {
                            $query->where(function ($query) use ($price) {
                                $query->whereNull('promo');
                                $query->where('price', '<=', $price);
                            })->orWhere(function ($query) use ($price) {
                                $query->whereNotNull('promo');
                                $query->where('promo', '<=', $price);
                            });
                        });
                    }
                }
            )
            ->groupBy('products.id')->having('sum', '>', 0);
        if ($order == 'solds') {
            $query = DB::table('order_product_color')
                ->joinSub($query, 'sub_query', function ($join) {
                    $join->on('order_product_color.product_id', '=', 'sub_query.id');
                })
                ->selectRaw('sub_query.*,sum(order_product_color.quantity) as sort_sum')
                ->groupBy(['sub_query.id'])
                ->orderByDesc('sort_sum');
        }
        if ($order == 'price-desc') {
            $query = $query
                ->orderByRaw("COALESCE(promo,price) DESC");
        }
        if ($order == 'price-asc') {
            $query = $query
                ->orderByRaw("COALESCE(promo,price) ASC");
        }
        if ($order == 'recent') {
            $query = $query
                ->orderByDesc('created_at');
        }
        if ($order == 'ancient') {
            $query = $query
                ->orderBy('created_at');
        }
        $pagination = $query->paginate(self::$page_count);
        $currentPage = $pagination->currentPage();
        $lastPage = $pagination->lastPage();
        $nextPage = $currentPage >= $lastPage ? $lastPage : $currentPage + 1;
        $previousPage = $currentPage <= 1 ? 1 : $currentPage - 1;
        $products = collect($pagination->items());
        $total = $pagination->total();
        // getting products colors.
        $ids = [];
        foreach ($products as $product) {
            array_push($ids, $product->id);
        }
        $colors = DB::table('color_product')
            ->join('colors', 'color_id', '=', 'colors.id')
            ->select([
                'color_id', 'product_id',
                'name', 'value1', 'value2',
                'value3', 'main_image'
            ])->where('quantity', '>', 0)
            ->whereIn('product_id', $ids)->get();
        // associating each product with its colors
        $products = $products->map(function ($product) use ($colors) {
            $product->colors = [];
            foreach ($colors as $color) {
                if ($product->id == $color->product_id)
                    array_push($product->colors, $color);
            }
            return $product;
        });
        return (object)[
            'products' => $products,
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
            'nextPage' => $nextPage,
            'previousPage' => $previousPage,
            'total' => $total
        ];
    }

    public static function get($id, $withColors = false, $withReviews = false, $withCount = false, $user_id = null)
    {
        $product = DB::table('products')
            ->join('brands', 'brand_id', '=', 'brands.id')
            ->join('categories', 'category_id', '=', 'categories.id')
            ->select(
                [
                    'products.*', 'brands.name as brand',
                    'categories.name as category'
                ]
            )
            ->when($user_id, function ($query, $user_id) use ($id) {
                $query->selectRaw('(select count(*) from saves where product_id = ? and user_id = ?) as saved', [$id, $user_id]);
            })
            ->where('deleted', '=', 0)
            ->where('products.id', '=', $id)
            ->get()->first();
        if (!$product)
            return null;
        // product colors.
        if ($withColors) {
            $colors = DB::table('color_product')
                ->join('colors', 'color_id', '=', 'colors.id')
                ->select(['id', 'color_id', 'name', 'quantity', 'deleted', 'main_image', 'value1', 'value2', 'value3'])
                ->where('deleted', '=', 0)
                ->where('quantity', '>', 0)
                ->where('product_id', '=', $id)
                ->get();
            // geting product images for each color.
            $color_ids = [];
            foreach ($colors as $color) {
                array_push($color_ids, $color->id);
            }
            $images = DB::table('products_images')
                ->select(['color_id', 'image'])->where('product_id', '=', $id)
                ->whereIn('color_id', $color_ids)->get();
            // associating images to product colors
            $colors = $colors->map(function ($color) use ($images) {
                $color->images = [];
                foreach ($images as $image) {
                    if ($image->color_id == $color->id) {
                        array_push($color->images, $image);
                    }
                }
                return $color;
            });
            $product->colors = $colors;
        }
        if ($withReviews) {
            // getting product reviews.
            $reviews = [];
            $score = null;
            $reviews = DB::table('reviews')
                ->join('users', 'user_id', '=', 'users.id')
                ->select(['users.name as name', 'score', 'feedback', 'reviews.created_at as date'])
                ->where('product_id', '=', $id)->orderByDesc('score')->get();
            $product->reviews = $reviews;
            if (count($reviews)) {
                $sum = 0;
                foreach ($reviews as $item)
                    $sum += $item->score;
                $score = $sum / count($reviews);
            }
            $product->score = $score;
        }
        if ($withCount) {
            // counting product orders
            $solds = DB::table('order_product_color')
                ->selectRaw('sum(quantity) as solds')
                ->where('product_id', '=', $id)
                ->get()->first()->solds;
            $product->solds = $solds;
        }

        return $product;
    }
    public static function get_by_ids($ids, $withColors = false)
    {
        $products = DB::table('products')->whereIn('id', $ids)->get();
        if ($withColors) {
            $rows = DB::table('color_product')
                ->whereIn('product_id', $ids)->get();
            foreach ($products as $product) {
                $product->colors = [];
                foreach ($rows as $row) {
                    if ($row->product_id != $product->id)
                        continue;
                    array_push($product->colors, $row);
                }
            }
        }
        return $products;
    }
    public static function store_color($data, $images)
    {
        DB::table('color_product')->insert($data);
        if (!$images)
            return;
        foreach ($images as $image) {
            DB::table('products_images')->insert([
                'product_id' => $data['product_id'],
                'color_id' => $data['color_id'],
                'image' => $image
            ]);
        }
    }
    public static function update($id, $data)
    {
        DB::table('products')->where('id', '=', $id)
            ->update($data);
    }
    public static function update_colors($id, $data)
    {
        foreach ($data as $item) {
            DB::table('color_product')
                ->where('color_id', '=', $item->id)
                ->where('product_id', '=', $id)
                ->update($item->data);
            if (!$item->images)
                continue;
            DB::table('products_images')
                ->where('color_id', '=', $item->data['color_id'])
                ->where('product_id', '=', $id)
                ->delete();
            foreach ($item->images as $image) {
                DB::table('products_images')
                    ->insert([
                        'product_id' => $id,
                        'color_id' => $item->data['color_id'],
                        'image' => $image
                    ]);
            }
        }
    }
    public static function delete($id)
    {
        $product = self::get($id, true);
        $orders = DB::table('order_product_color')
            ->where('product_id', '=', $id)->get();
        if (!$orders->first()) {
            DB::table('products')->where('id', '=', $id)
                ->delete();
            foreach ($product->colors as $color) {
                self::delete_color($id, $color->id, $color);
            }
        } else {
            DB::table('products')->where('id', '=', $id)
                ->update(['deleted' => 1]);
            foreach ($product->colors as $color) {
                if (!$color->deleted)
                    self::delete_color($id, $color->id, $color);
            }
        }
        DB::table('saves')->where('product_id', '=', $id)
            ->delete();
        DB::table('reviews')->where('product_id', '=', $id)
            ->delete();
    }
    public static function delete_color($product_id, $color_id, $color)
    {
        $orders = DB::table('order_product_color')
            ->where('product_id', '=', $product_id)
            ->where('color_id', '=', $color_id)->get();
        if (!$orders->first()) {
            DB::table('color_product')->where('product_id', '=', $product_id)
                ->where('color_id', '=', $color_id)->delete();
            Storage::delete("public/uploads/$color->main_image");
            foreach ($color->images as $image) {
                Storage::delete("public/uploads/$image->image");
            }
        } else {
            DB::table('color_product')->where('product_id', '=', $product_id)
                ->where('color_id', '=', $color_id)->update(['deleted' => 1]);
            foreach ($color->images as $image) {
                Storage::delete("public/uploads/$image->image");
            }
        }
    }
}