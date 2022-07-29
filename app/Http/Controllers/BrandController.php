<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::all();
        return view('admin.brands', [
            'brands' => $brands
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:brands']
        ]);
        Brand::store([
            'name' => $request->input('name'),
        ]);
        return redirect()->route('brands')->with([
            'alert' => (object)[
                'type' => 'success',
                'message' => 'nouvelle marke est crée!'
            ]
        ]);
    }
    public function edit($id)
    {
        return view('admin.edit-brand', [
            'brand' => Brand::get($id)
        ]);
    }
    public function update(Request $request, $id)
    {
        $fields = [];
        $inputs = ['name'];
        $request->validate([
            'name' => [Rule::unique('brands')->ignore($id)]
        ]);
        foreach ($inputs as $input) {
            if ($request->input($input)) {
                $fields[$input] = $request->input($input);
            }
        }
        if (!count($fields))
            return back();
        Brand::update($fields, $id);
        return back()->with([
            'alert' => (object)[
                'type' => 'success',
                'message' => 'la marke est modifiée!'
            ]
        ]);
    }
    public function delete($id)
    {
        try {
            Brand::delete($id);
            return back()->with([
                'alert' => (object)[
                    'type' => 'success',
                    'message' => 'la marke est supprimé!'
                ]
            ]);
        } catch (QueryException $_) {
            return back()->with([
                'alert' => (object)[
                    'type' => 'error',
                    'message' => "impossible de supprimer la marke,
                    il y a autres produits qui l'utilise"
                ]
            ]);
        }
    }
}