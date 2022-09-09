<?php

namespace App\Http\Controllers;

use App\Models\Wilaya;

class WilayaController extends Controller
{
    public function index()
    {
        return view('admin.wilayas', [
            'wilayas' => Wilaya::all()
        ]);
    }
    public function store()
    {
        $data = request()->validate([
            'id' => ['required', 'unique:wilayas,id', 'numeric', 'min:1'],
            'name' => ['required', 'unique:wilayas,name'],
            'home_shipment' => ['required', 'numeric'],
            'desk_shipment' => ['nullable', 'numeric'],
            'duration' => ['required']
        ]);
        $duration = $data['duration'];
        $data['duration'] = "($duration)";
        Wilaya::insert($data);
        return back()->with([
            'alert' => (object) [
                'type' => 'success',
                'message' => 'la wilaya a été ajouté'
            ]
        ]);
    }
    public function edit($id)
    {
        $wilaya = Wilaya::get($id);
        if (!$wilaya)
            return redirect('/404');
        return view('admin.edit-wilaya', ['wilaya' => $wilaya]);
    }
    public function update($id)
    {
        $data = request()->validate([
            'id' => ['required', "unique:wilayas,id, $id", 'numeric', 'min:1'],
            'name' => ['required', "unique:wilayas,name, $id"],
            'home_shipment' => ['required', 'numeric'],
            'desk_shipment' => ['nullable', 'numeric'],
            'duration' => ['required']
        ]);
        Wilaya::update($id, $data);
        return back();
    }
    public function delete($id)
    {
        if (Wilaya::delete($id))
            return back()->with([
                'alert' => (object) [
                    'type' => 'success',
                    'message' => 'la wilaya a été supprimé'
                ]
            ]);
        else
            return back()->with([
                'alert' => (object) [
                    'type' => 'error',
                    'message' => 'imposible de supprimé la wilaya, 
                    car elle est assoscié avec autres commandes'
                ]
            ]);
    }
}