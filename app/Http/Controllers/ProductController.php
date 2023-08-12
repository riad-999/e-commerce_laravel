<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * exp
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
        ]);
    }
    public function index(Request $request)
    {
        if ($request->input('order'))
            $order = $request->input('order');
        elseif ($request->session()->get('order'))
            $order = $request->session()->get('order');
        else
            $order = 'solds';
        $request->session()->put('order', $order);
        $paginate = Product::index($request, $order);
        // dd($paginate);
        $query = $request->query();
        $query['page'] = $paginate->nextPage;
        $nextUrl = $request->fullUrlWithQuery($query);
        $query['page'] = $paginate->previousPage;
        $prevUrl = $request->fullUrlWithQuery($query);
        return view('products', [
            'Brands' => Brand::all(),
            'Categories' => Category::all(),
            'products' => $paginate->products,
            'currentPage' => $paginate->currentPage,
            'lastPage' => $paginate->lastPage,
            'nextUrl' => $nextUrl,
            'prevUrl' => $prevUrl,
            'total' => $paginate->total,
            'search' => $request->input('search'),
            'promo' => $request->input('promo'),
            'price' => $request->input('price'),
            'categories' => $request->input('categories'),
            'brands' => $request->input('brands'),
            'sort' => $order
        ]);
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
        ]);
    }
    public function create(Request $request)
    {
        if (!$request->session()->get('first-submit'))
            return back();
        return view('admin.create-product', [
            'colors' => Color::all(),
            'count' => $request->session()->get('count'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product =  Product::get(
            $id,
            true,
            true,
            true,
            Auth::check() ? Auth::user()->id : null
        );
        return view('show-product', [
            'product' => $product
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
            'count' => ['required', 'numeric']
        ]);
        $arr = ['name', 'description', 'category', 'brand', 'price', 'count'];
        foreach ($arr as $item) {
            $request->session()->put($item, $validated[$item]);
        }
        $request->session()->put('first-submit', true);
        return redirect(route('create-product'));
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
            // $count_files = $request->file("other-images$i")
            //     ? count($request->file("other-images$i")) : 0;
            // $request->session()->put("file-count$i", $count_files);
            $rules["color$i"] = ['required', 'exists:colors,id'];
            $rules["quantity$i"] = ['required', 'numeric', "gt:0"];
            $rules["main-image$i"] = ['required', 'image', 'max:200', 'mimes:jpg,jpeg,png,webp,svg,gif'];
            $rules["other-images$i.*"] = ['image', 'max:200', 'mimes:jpg,jpeg,png,webp,svg,gif'];
        }
        $validated = $request->validate($rules);
        // store the product
        $product_id = DB::table('products')->insertGetId([
            'category_id' => $request->session()->get('category'),
            'brand_id' => $request->session()->get('brand'),
            'name' => $request->session()->get('name'),
            'description' => $request->session()->get('description'),
            'price' => $request->session()->get('price'),
            'created_at' => now(),
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
        $arr = ['name', 'description', 'category', 'brand', 'price', 'count', 'first-submit'];
        // for ($i = 1; $i <= $count; $i++) {
        //     array_push($arr, "file-count$i");
        // }
        // foreach ($arr as $item) {
        //     $request->session()->forget($item);
        // }
        return redirect(route('initial-create-product'))
            ->with([
                'alert' => (object) [
                    'type' => 'success',
                    'le produit a été creé'
                ]
            ]);
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

        return view('admin.edit-product', [
            'product' => $product,
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }

    public function edit_colors($id)
    {
        $product = Product::get($id, true);
        if (!$product)
            return redirect('/404');
        $colors = Color::all();
        return view('admin.edit-product-colors', [
            'count' => count($product->colors),
            'product' => $product,
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
    public function update(Request $request, $id)
    {
        $inputs = ['name', 'description', 'price', 'brand_id', 'category_id'];
        $data = [];
        foreach ($inputs as $input) {
            if ($request->input($input))
                $data[$input] = $request->input($input);
        }
        if (!count($data))
            return back();
        Product::update($id, $data);
        return back()->with([
            'alert' => (object)[
                'type' => 'success',
                'message' => "le produit est modifié"
            ]
        ]);
    }

    public function update_colors(Request $request, $id)
    {
        $product = Product::get($id, true);
        $data = [];
        $ids = [];
        $rules = [];
        foreach ($product->colors as $color) {
            array_push($ids, $request->input("$color->name"));
            $rules["main-image-$color->name"] = ['image', 'max:200', 'mimes:jpg,jpeg,png,webp,svg,gif'];
            $rules["other-images-$color->name"] = ['image', 'max:200', 'mimes:jpg,jpeg,png,webp,svg,gif'];
        }
        $request->validate($rules);
        $counts = array_count_values($ids);
        foreach ($counts as $item) {
            if ($item > 1) {
                return back()->with([
                    'alert' => (object)[
                        'type' => 'error',
                        'message' => "il y a une redandance dans les coleurs"
                    ]
                ]);
            }
        }
        foreach ($product->colors as $color) {
            $object = (object)['id' => $color->id];
            $object->images = null;
            if ($color_id = $request->input("$color->name")) {
                $object->data['color_id'] = $color_id;
            }
            if ($quantity = $request->input("quantity-$color->name")) {
                $object->data['quantity'] = $quantity;
            }
            if ($request->hasFile("main-image-$color->name")) {
                $path = $request->file("main-image-$color->name")->store('public/uploads');
                $object->data['main_image'] = basename($path);
                Storage::delete("public/uploads/$color->main_image");
            }
            if ($request->hasFile("other-images-$color->name")) {
                $object->images = [];
                foreach ($request->file("other-images-$color->name") as $file) {
                    $path = $file->store('public/uploads');
                    array_push($object->images, basename($path));
                    foreach ($color->images as $image) {
                        Storage::delete("public/uploads/$image->image");
                    }
                }
            }
            array_push($data, $object);
        }
        Product::update_colors($id, $data);
        // foreach ($product->colors as $color) {
        //     session()->forget("file-count-$color->name");
        // }
        return back()->with([
            'alert' => (object)[
                'type' => 'success',
                'message' => "les coleurs sont modifié"
            ]
        ]);
    }
    public function edit_promo($id)
    {
        $product = Product::get($id);
        if (!$product)
            return redirect('/404');
        return view('admin.edit-promo', [
            'product' => $product
        ]);
    }
    public function update_promo(Request $request, $id)
    {
        if ($request->input('promo') == '0') {
            Product::update($id, ['promo' => null, 'expires' => null]);
        } else {
            Product::update($id, [
                'promo' => $request->input('promo'),
                'expires' => $request->input('expires')
            ]);
        }
        return back()->with([
            'alert' => (object)[
                'type' => 'success',
                'message' => "le promo est modifié"
            ]
        ]);
    }
    public function store_color(Request $request, $id)
    {
        $request->validate([
            'quantity' => ['required', 'numeric', 'gt:0'],
            'color' => [
                'required', 'exists:colors,id',
                Rule::unique('color_product', 'color_id')->where('product_id', $id)
            ],
            'main-image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,svg,gif'],
            'other-images.*' => ['image', 'mimes:jpg,jpeg,png,webp,svg,gif']
        ]);
        $name = basename($request->file('main-image')->store('public/uploads'));
        $images = null;
        if ($request->hasFile('other-images')) {
            $images = [];
            foreach ($request->file('other-images') as $file) {
                array_push($images, basename($file->store('public/uploads')));
            }
        }
        Product::store_color([
            'quantity' => $request->input('quantity'),
            'color_id' => $request->input('color'),
            'product_id' => $id,
            'main_image' => $name
        ], $images);

        return back()->with([
            'alert' => (object)[
                'type' => 'success',
                'message' => "la coleur est crée"
            ]
        ]);
    }

    public function destroy($id)
    {
        Product::delete($id);
        return back()->with([
            'alert' => (object)[
                'type' => 'success',
                'message' => "le produit est supprimé"
            ]
        ]);
    }

    public function destroy_color($product_id, $color_id)
    {
        $product = Product::get($product_id, true);
        $color = null;
        foreach ($product->colors as $clr) {
            if ($clr->id == $color_id) {
                $color = $clr;
            }
        }
        Product::delete_color($product_id, $color_id, $color);
        return back()->with([
            'alert' => (object)[
                'type' => 'success',
                'message' => "la coleur est supprimé"
            ]
        ]);
    }
}