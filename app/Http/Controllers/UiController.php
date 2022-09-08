<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UiController extends Controller
{
    private $limit = 12;
    private function devide($collection, $len)
    {
        $new_collection = collect([]);
        $count = 0;
        $current_group = [];
        foreach ($collection as $index => $item) {
            array_push($current_group, $item);
            $count++;
            if ($index + 1 == count($collection)) {
                $new_collection->push($current_group);
                break;
            }
            if ($count == $len) {
                $count = 0;
                $new_collection->push($current_group);
                $current_group = [];
            }
        }
        // dd($current_group, $new_collection);
        // dd($new_collection);
        return $new_collection;
    }
    public function home()
    {
        $ui = json_decode(
            file_get_contents(
                storage_path('app/admin.json')
            )
        );
        $most_ordered = DB::table('products')
            ->join('order_product_color', 'products.id', '=', 'order_product_color.product_id')
            ->select(['products.id', 'name', 'products.price', 'promo'])
            ->selectRaw('count(*) as count')
            ->selectRaw('(select main_image from color_product where color_product.product_id = products.id limit 1) as image')
            ->where('products.deleted', '=', '0')
            ->whereRaw('0 != (select sum(quantity) from color_product where color_product.product_id = products.id group by color_product.product_id)')
            ->groupBy('products.id')->orderByDesc('count')
            ->limit($this->limit)->get();
        $most_ordered_g1 = $this->devide($most_ordered, 3);
        $most_ordered_g2 = $this->devide($most_ordered, 2);
        $cats_g1 = [];
        $cats_g2 = [];
        foreach ($ui->categories as $category_id) {
            $products = DB::table('products')
                ->join('categories', 'category_id', '=', 'categories.id')
                ->join('order_product_color', 'products.id', '=', 'order_product_color.product_id')
                ->select(['products.id', 'category_id', 'promo', 'products.price', 'products.name', 'categories.name as category'])
                ->selectRaw('(select main_image from color_product where color_product.product_id = products.id limit 1) as image')
                ->selectRaw('count(*) as count')
                ->where('products.deleted', '=', '0')
                ->whereRaw('0 != (select sum(quantity) from color_product where color_product.product_id = products.id group by color_product.product_id)')
                ->where('category_id', '=', $category_id)
                ->groupBy('products.id')->orderByDesc('count')
                ->limit(6)->get();
            array_push($cats_g1, $this->devide($products, 3));
            array_push($cats_g2, $this->devide($products, 2));
        }
        // dd($cats_g1);
        return view('home', [
            'ui' => $ui,
            'most_ordered' => $most_ordered_g1,
            'most_ordered_g2' => $most_ordered_g2,
            'cats_g1' => $cats_g1,
            'cats_g2' => $cats_g2
        ]);
    }
    public function edit()
    {
        $ui = json_decode(
            file_get_contents(
                storage_path('app/admin.json')
            )
        );
        return view('admin.edit-home', [
            'ui' => $ui,
            'categories' => Category::all(),
        ]);
    }
    public function update(Request $request)
    {
        if (request()->hasFile('images')) {
            session()->flash('file-count', count(request()->file('images')));
        } else {
            session()->flash('file-count', 0);
        }
        // if (request()->hasFile('images'))
        request()->validate([
            'images.*' => ['image', 'file|max:400', 'mimes:jpg,jpeg,png,webp,svg,gif']
        ]);
        $ui = json_decode(
            file_get_contents(
                storage_path('app/admin.json')
            )
        );
        $ui->top_note = request('top-note');
        $ui->categories = json_decode(request('categories'));
        if (request()->hasFile('images')) {
            foreach ($ui->images as $image)
                Storage::delete("/ui-images/$image");
            $ui->images = [];
            foreach (request()->file('images') as $file) {
                $file_name = basename($file->store('public/ui-images'));
                array_push($ui->images, $file_name);
            }
        }
        Storage::disk('local')->put('admin.json', json_encode($ui));
        return back();
    }
}