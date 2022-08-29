<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use App\Rules\Cut;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PromoCodeController extends Controller
{
    public function index()
    {
        return view('admin.promo-codes', [
            'codes' => PromoCode::all()
        ]);
    }
    public function store(Request $request)
    {
        $date = now()->format('Y-m-d');
        $inputs = $request->validate([
            'code' => ['required', 'min:3', 'unique:promo_codes,code'],
            'expires' => ['required', 'date', "after:$date"],
            'type' => ['required'],
            'fixe-cut' => $request->input('type') == 'fixe' ? ['required', 'numeric', 'min:5', 'max:95'] : []
        ]);
        $data = ['code' => $inputs['code']];
        $data['expires'] = $inputs['expires'];
        $data['for_all'] = $inputs['type'] == 'fixe';
        $data['for_all_cut'] = $request->input('fixe-cut');
        PromoCode::insert($data);
        return back()->with([
            'alert' => (object) [
                'type' => 'success',
                'message' => 'le code promo a été ajouté'
            ]
        ]);
    }
    public function edit($id)
    {
        if (!$promo_code = PromoCode::get($id, true))
            return redirect('/404');
        return view('admin.edit-promo-code', [
            'code' => $promo_code
        ]);
    }
    public function update(Request $request, $id)
    {
        $code = PromoCode::get($id);
        if (!$code) {
            return back()->with([
                'alert' => (object) [
                    'type' => 'error',
                    'message' => 'lien invalide'
                ]
            ]);
        }
        $date = now()->format('Y-m-d');
        $inputs = $request->validate([
            'code' => ['required', 'min:3', Rule::unique('promo_codes')->ignore($id)],
            'expires' => ['required', 'date', "after:$date"],
            'type' => ['required'],
            'fixe-cut' => $request->input('type') == 'fixe' ? ['required', 'numeric', 'min:5', 'max:95'] : []
        ]);
        PromoCode::update($id, [
            'code' => $inputs['code'],
            'expires' => $inputs['expires'],
            'for_all' => $inputs['type'] == 'fixe',
            'for_all_cut' => $request->input('fixe-cut')
        ]);
        if (!$code->for_all && $inputs['type'] == 'fixe') {
            PromoCode::delete_associations($id);
        }
        return back()->with([
            'alert' => (object) [
                'type' => 'success',
                'message' => 'le code promo a été modifié'
            ]
        ]);
    }
    public function promo_code_assocations(Request $request, $id)
    {
        $paginatation = PromoCode::get_associations($id, $request);
        $query = $request->query();
        $query['page'] = $paginatation->nextPage;
        $nextUrl = $request->fullUrlWithQuery($query);
        $query['page'] = $paginatation->previousPage;
        $prevUrl = $request->fullUrlWithQuery($query);
        return view('admin.promo-code-assocations', [
            'products' => $paginatation->products,
            'code' => $paginatation->code,
            'currentPage' => $paginatation->currentPage,
            'lastPage' => $paginatation->lastPage,
            'nextUrl' => $nextUrl,
            'prevUrl' => $prevUrl,
        ]);
    }
    public function create_promo_code_assocation(Request $request, $id)
    {
        if (!$paginatation = PromoCode::products($id, $request))
            return redirect(route('promo-codes'))->with([
                'alert' => (object) [
                    'type' => 'error',
                    'message' => 'lien invalide'
                ]
            ]);
        $query = $request->query();
        $query['page'] = $paginatation->nextPage;
        $nextUrl = $request->fullUrlWithQuery($query);
        $query['page'] = $paginatation->previousPage;
        $prevUrl = $request->fullUrlWithQuery($query);
        return view('admin.create-promo-code-association', [
            'products' => $paginatation->products,
            'code' => $paginatation->code,
            'currentPage' => $paginatation->currentPage,
            'lastPage' => $paginatation->lastPage,
            'nextUrl' => $nextUrl,
            'prevUrl' => $prevUrl,
        ]);
    }
    public function store_promo_code_assocation(Request $request, $id)
    {
        $all = $request->all();
        PromoCode::store_association($id, $all['product'], $all['cut']);
        return response(status: 201);
    }
    public function update_promo_code_assocation(Request $request, $id, $product_id)
    {
        $cut_list = [];
        for ($i = 5; $i <= 95; $i += 5) {
            array_push($cut_list, "$i");
        }
        if (!$request->input('cut') || !in_array($request->input('cut'), $cut_list))
            return back()->with([
                'alert' => (object) [
                    'type' => 'error',
                    'message' => 'la réduction doit ètre choisit'
                ]
            ]);
        PromoCode::update_association($id, $product_id, $request->input('cut'));
        return back()->with([
            'alert' => (object) [
                'type' => 'success',
                'message' => 'la réduction a été modifié'
            ]
        ]);
    }
    public function delete_promo_code_assocation($id, $product_id)
    {
        PromoCode::delete_association($id, $product_id);
        return back()->with([
            'alert' => (object) [
                'type' => 'success',
                'message' => "l'association a été supprimé"
            ]
        ]);
    }
    public function delete($id)
    {
        PromoCode::delete($id);
        return back()->with([
            'alert' => (object) [
                'type' => 'success',
                'message' => 'la code promo a été modifié'
            ]
        ]);
    }
}