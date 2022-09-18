<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ColorController extends Controller
{
    public function index(Request $request)
    {
        $colors = Color::all($request);
        return view('admin.colors', [
            'colors' => $colors,
            'name' => $request->input('name')
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:colors']
        ]);
        if ($request->input('color1') == '#010101') {
            return back()->withInput()->withErrors(['color1' => 'ce champ ne dois pas etre vide']);
        }

        $colors = Color::all();
        $arr = [$request->input('color1')];

        if (($clr = $request->input('color2')) &&
            $request->input('color2') != '#010101'
        ) {
            if ($clr === $request->input('color1')) {
                return back()->withErrors([
                    'color2' => 'cette couleur doit être diffirente'
                ])->withInput();
            }
            array_push($arr, $request->input('color2'));
        } else {
            if (
                $request->input('color3') &&
                $request->input('color3') != '#010101'
            )
                return back()->withErrors([
                    'color2' => 'cette couleur doit être choisi'
                ])->withInput();
        }
        if (($clr3 = $request->input('color3')) &&
            $request->input('color3') != '#010101'
        ) {
            if ($clr3 === $clr || $clr3 === $request->input('color1')) {
                return back()->withErrors([
                    'color3' => 'cette couleur doit être diffirente'
                ])->withInput();
            }
            array_push($arr, $request->input('color3'));
        }
        $exists = false;
        foreach ($colors as $color) {
            $_arr = [$color->value1];
            if ($color->value2) {
                array_push($_arr, $color->value2);
            }
            if ($color->value3) {
                array_push($_arr, $color->value3);
            }
            if (count($arr) == count($_arr)) {
                $exists = true;
                foreach ($arr as $item) {
                    if (!in_array($item, $_arr)) {
                        $exists = false;
                        break;
                    }
                }
                if ($exists)
                    return back()->with([
                        'alert' => (object)[
                            'type' => 'error',
                            'message' => 'la coleur que vous avez choisi déja existe!'
                        ]
                    ])->withInput();
            }
        }
        Color::store([
            'name' => $request->input('name'),
            'value1' => $request->input('color1'),
            'value2' => $request->input('color2'),
            'value3' => $request->input('color3')
        ]);
        return redirect()->route('colors')->with([
            'alert' => (object)[
                'type' => 'success',
                'message' => 'nouvelle couleur est ajoutée!'
            ]
        ]);
    }
    public function edit($id)
    {
        return view('admin.edit-color', [
            'color' => Color::get($id),
            'id' => $id
        ]);
    }
    public function update(Request $request, $id)
    {
        $Color = Color::get($id);
        $fields = [];
        $inputs = [
            'name' => 'name',
            'color1' => 'value1',
            'color2' => 'value2',
            'color3' => 'value3'
        ];
        $request->validate([
            'name' => [Rule::unique('colors')->ignore($id), 'min:1']
        ]);
        if ($request->input('color1') == '#010101') {
            return back()->withErrors(['color1' => 'ce champ ne dois pas etre vide']);
        }

        foreach ($inputs as $key => $value) {
            if ($request->has($key)) {
                if ($request->input($key) == '#010101')
                    $fields[$value] = null;
                else
                    $fields[$value] = $request->input($key);
            }
        }

        if (!count($fields))
            return back();

        $clrs = [];
        $tmp = [
            'color1' => 'value1',
            'color2' => 'value2',
            'color3' => 'value3'
        ];
        foreach ($tmp as $key => $value) {
            if ($request->input($key)) {
                if ($request->input($key) == '#010101')
                    array_push($clrs, null);
                else
                    array_push($clrs, $request->input($key));
            } else {
                array_push($clrs, $Color->{$value});
            }
        }

        $colors = Color::all()->filter(
            fn ($color) => $color->id != $id
        );
        if ($clr = $clrs[1]) {
            if ($clr === $clrs[0]) {
                return back()->withErrors([
                    'color2' => 'cette couleur doit être diffirente'
                ])->withInput();
            }
        } else {
            if ($clrs[2])
                return back()->withErrors([
                    'color2' => 'cette couleur doit être choisi'
                ])->withInput();
        }
        if ($clr3 = $clrs[2]) {
            if ($clr3 === $clr || $clr3 === $clrs[0]) {
                return back()->withErrors([
                    'color3' => 'cette couleur doit être diffirente'
                ])->withInput();
            }
        }
        $arr = array_filter($clrs);
        $exists = false;
        foreach ($colors as $color) {
            $_arr = [$color->value1];
            if ($color->value2) {
                array_push($_arr, $color->value2);
            }
            if ($color->value3) {
                array_push($_arr, $color->value3);
            }
            if (count($arr) == count($_arr)) {
                $exists = true;
                foreach ($arr as $item) {
                    if (!in_array($item, $_arr)) {
                        $exists = false;
                        break;
                    }
                }
                if ($exists)
                    return back()->with([
                        'alert' => (object)[
                            'type' => 'error',
                            'message' => 'la coleur que vous avez choisi déja existe!'
                        ]
                    ])->withInput();
            }
        }


        Color::update($fields, $id);
        return back()->with([
            'alert' => (object)[
                'type' => 'success',
                'message' => 'la couleur est modifiée!'
            ]
        ]);
    }
    public function delete($id)
    {
        if (Color::delete($id))
            return back()->with([
                'alert' => (object)[
                    'type' => 'success',
                    'message' => 'la couleur est supprimé!'
                ]
            ]);
        else
            return back()->with([
                'alert' => (object)[
                    'type' => 'error',
                    'message' => "impossible de supprimer la coleur car
                    il y a d'autres produits qui l'utilise, ou pour préserver 
                    l'historique des commandes."
                ]
            ]);
    }
}