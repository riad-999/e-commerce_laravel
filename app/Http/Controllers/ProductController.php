<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->has('second-submit')) {
            return 'pish';
            $rules = [];
            $count = $request->input('count', null);
            if (!$count)
                return back();
            for ($i = 1; $i <= $count; $i++) {
                $rules["color$i"] = ['required', 'exists:colors,id'];
                $rules["quantity$i"] = ['required', 'numeric'];
                $rules["main-image$i"] = ['required', 'image', 'mimes:jpg,jpeg,png,webp,svg,gif'];
                $rules["other-images$i.*"] = ['required', 'image', 'mimes:jpg,jpeg,png,webp,svg,gif'];
            }
            $validated = $request->validate($rules);
            return 'pish pish';
        } elseif ($request->has('first-submit')) {
            $validated = $request->validate([
                'name' => ['required', 'unique:products', 'max:255'],
                'description' => ['required', 'nullable', 'max:65535'],
                'category' => ['required', 'numeric', 'exists:categories,id'],
                'brand' => ['required', 'numeric', 'exists:brands,id'],
                'price' => ['required', 'numeric'],
                'count' => ['required', 'numeric', 'max:8']
            ]);
            $arr = ['name', 'description', 'category', 'brand', 'price', 'count'];
            foreach ($arr as $item) {
                $request->session()->put($item, $validated[$item]);
            }
            $colors = Color::all()->map(
                function ($color) {
                    $cols = [$color->value1];
                    if ($color->value2)
                        array_push($cols, $color->value2);
                    if ($color->value3)
                        array_push($cols, $color->value3);
                    return
                        (object)[
                            'id' => $color->id,
                            'name' => $color->name,
                            'colors' => $cols,
                        ];
                }
            );
            return view('products-create', [
                'colors' => $colors,
                'count' => $validated['count'],
                'first' => false
            ]);
        } else {
            $brands = Brand::all();
            $categories = Category::all();

            $brands = $brands->map(fn ($brand) => (object)[
                'name' => $brand->name,
                'value' => $brand->id
            ]);
            $categories = $categories->map(fn ($category) => (object)[
                'name' => $category->name,
                'value' => $category->id
            ]);
            return view('products-create', [
                'first' => true,
                'brands' => $brands,
                'categories' => $categories
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return 'pish';
        $rules = [];
        $count = $request->input('count', null);
        if (!$count)
            return back();
        for ($i = 1; $i <= $count; $i++) {
            $rules["color$i"] = ['required', 'exists:colors,id'];
            $rules["quantity$i"] = ['required', 'numeric'];
            $rules["main-image$i"] = ['required', 'image', 'mimes:jpg,jpeg,png,webp,svg,gif'];
            $rules["other-images$i.*"] = ['required', 'image', 'mimes:jpg,jpeg,png,webp,svg,gif'];
        }
        $validated = $request->validate($rules);
        return 'pish pish';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}