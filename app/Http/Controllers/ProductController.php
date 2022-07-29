<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_index(Request $request)
    {
        $paginate = Product::all($request, true);
        $query = $request->query();
        $query['page'] = $paginate->nextPage;
        $nextUrl = $request->fullUrlWithQuery($query);
        $query['page'] = $paginate->previousPage;
        $prevUrl = $request->fullUrlWithQuery($query);
        return view('admin.admin-products', [
            'products' => $paginate->products,
            'currentPage' => $paginate->currentPage,
            'lastPage' => $paginate->lastPage,
            'nextUrl' => $nextUrl,
            'prevUrl' => $prevUrl,
            'id' => $request->input('id'),
            'name' => $request->input('name'),
            'promo' => $request->input('promo'),
            'archived' => $request->input('archived')
        ]);
    }
    public function index(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function initial_create(Request $request)
    {
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
        return view('initial-products-create', [
            'brands' => $brands,
            'categories' => $categories,
            // 'session' => $request->session()
        ]);
    }
    public function create(Request $request)
    {
        if (!$request->session()->get('first-submit'))
            return back();
        $request->session()->forget('first-submit');
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
            'count' => $request->session()->get('count'),
            // 'session' => $request->session()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function initial_store(Request $request)
    {
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
        $request->session()->put(
            'first-submit',
            $request->input('first-submit'),
        );
        return redirect('/products/create');
    }
    public function store(Request $request)
    {
        $rules = [];
        $count = $request->session()->get('count');
        if (!$count)
            return back()->withInput()
                ->with(['alert' => (object)[
                    'type' => 'error',
                    'content' => 'something went wrong'
                ]]);
        for ($i = 1; $i <= $count; $i++) {
            $count_files = $request->file("other-images$i")
                ? count($request->file("other-images$i")) : 0;
            $request->session()->put("file-count$i", $count_files);
            $rules["color$i"] = ['required', 'exists:colors,id'];
            $rules["quantity$i"] = ['required', 'numeric', "gt:0"];
            $rules["main-image$i"] = ['required', 'image', 'mimes:jpg,jpeg,png,webp,svg,gif'];
            $rules["other-images$i"] = ['required'];
            $rules["other-images$i.*"] = ['image', 'mimes:jpg,jpeg,png,webp,svg,gif'];
        }
        $validated = $request->validate($rules);
        // return $validated;
        // store the product
        $product_id = DB::table('products')->insertGetId([
            'category_id' => $request->session()->get('category'),
            'brand_id' => $request->session()->get('brand'),
            'name' => $request->session()->get('name'),
            'description' => $request->session()->get('description'),
            'price' => $request->session()->get('price'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        for ($i = 1; $i <= $count; $i++) {
            // loop over the colors.
            // store color-product compinations with the main image and quantity.
            // store color-product images.
            $path = $request->file("main-image$i")->store('public/uploads');
            $file_name = basename($path);
            DB::table('color_product')->insert([
                'product_id' => $product_id,
                'color_id' => $validated["color$i"],
                'quantity' => $validated["quantity$i"],
                'main_image' => $file_name
            ]);
            $images = [];
            foreach ($request->file("other-images$i") as $file) {
                $file_name = basename($file->store('public/uploads'));
                DB::table('products_images')->insert([
                    'product_id' => $product_id,
                    'color_id' => $validated["color$i"],
                    'image' => $file_name
                ]);
            }
        }
        // cleaning session.
        $arr = ['name', 'description', 'category', 'brand', 'price', 'count'];
        for ($i = 1; $i <= $count; $i++) {
            array_push($arr, "file-count$i");
        }
        foreach ($arr as $item) {
            $request->session()->forget($item);
        }
        return redirect(route('initial-create-product'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product =  Product::get($id, true, true, true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::get($id, true);
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

        return view('product-edit', [
            'product' => $product,
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }

    public function edit_colors($id)
    {
        $product = Product::get($id, true);
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
        // foreach ($colors as $color) {
        //     if ($color_ids->contains($color->id))
        //         array_push($product_colors, $color);
        // }
        foreach ($product->colors as $color) {
            $cols = [$color->value1];
            if ($color->value2)
                array_push($cols, $color->value2);
            if ($color->value3)
                array_push($cols, $color->value3);
            $color->colors = $cols;
        }
        return view('product-edit-colors', [
            'count' => count($product->colors),
            'product' => $product,
            // 'product_colors' => $product_colors,
            'colors' => $colors
        ]);
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