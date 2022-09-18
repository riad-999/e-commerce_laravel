<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        return view('admin.categories', [
            'categories' => $categories
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:categories,name']
        ]);
        Category::store([
            'name' => $request->input('name'),
            // 'description' => $request->input('description')
        ]);
        return redirect()->route('categories')->with([
            'alert' => (object)[
                'type' => 'success',
                'message' => 'nouvelle catogrie est crée!'
            ]
        ]);
    }
    public function edit($id)
    {
        return view('admin.edit-category', [
            'category' => Category::get($id)
        ]);
    }
    public function update(Request $request, $id)
    {
        // $inputs = ['name', 'description'];
        $request->validate([
            'name' => [Rule::unique('categories')->ignore($id)]
        ]);
        // foreach ($inputs as $input) {
        //     if ($request->input($input)) {
        //         $fields[$input] = $request->input($input);
        //     }
        // }
        // if (!count($fields))
        //     return back();
        Category::update(['name' => $request->input('name')], $id);
        return back()->with([
            'alert' => (object)[
                'type' => 'success',
                'message' => 'la catégorie est modifiée!'
            ]
        ]);
    }
    public function delete($id)
    {
        if (Category::delete($id))
            return back()->with([
                'alert' => (object)[
                    'type' => 'success',
                    'message' => 'la catégorie est supprimé!'
                ]
            ]);
        else
            return back()->with([
                'alert' => (object)[
                    'type' => 'error',
                    'message' => "impossible de supprimer la catégorie,
                    il y a autres produits qui l'utilise"
                ]
            ]);
    }
}