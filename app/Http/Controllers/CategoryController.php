<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

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
            'name' => ['required', 'unique:categories']
        ]);
        Category::store([
            'name' => $request->input('name'),
            'description' => $request->input('description')
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
        $fields = [];
        $inputs = ['name', 'description'];
        $request->validate([
            'name' => [Rule::unique('categories')->ignore($id)]
        ]);
        foreach ($inputs as $input) {
            if ($request->input($input)) {
                $fields[$input] = $request->input($input);
            }
        }
        if (!count($fields))
            return back();
        Category::update($fields, $id);
        return back()->with([
            'alert' => (object)[
                'type' => 'success',
                'message' => 'la catégorie est modifiée!'
            ]
        ]);
    }
    public function delete($id)
    {
        try {
            Category::delete($id);
            return back()->with([
                'alert' => (object)[
                    'type' => 'success',
                    'message' => 'la catégorie est supprimé!'
                ]
            ]);
        } catch (QueryException $_) {
            return back()->with([
                'alert' => (object)[
                    'type' => 'error',
                    'message' => "impossible de supprimer la catégorie,
                    il y a autres produits qui l'utilise"
                ]
            ]);
        }
    }
}