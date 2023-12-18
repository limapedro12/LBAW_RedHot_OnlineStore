<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PromoCodeController extends Controller
{
    public function index()
    {
        $promoCodes = PromoCode::all();
        return view('promo_codes.index', ['promoCodes' => $promoCodes]);
    }

    public function create()
    {
        return view('promo_codes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:promo_codes,codigo',
            'desconto' => 'required|numeric|between:0,100',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'id_administrador' => 'required|exists:administrador,id',
        ]);

        PromoCode::create($request->all());

        return redirect()->route('promo_codes.index')
            ->with('success', 'Promo code created successfully!');
    }

    public function edit($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        return view('promo_codes.edit', ['promoCode' => $promoCode]);
    }

    public function update(Request $request, $id)
    {
        $promoCode = PromoCode::findOrFail($id);

        $request->validate([
            'codigo' => [
                'required',
                Rule::unique('promo_codes', 'codigo')->ignore($promoCode->id),
            ],
            'desconto' => 'required|numeric|between:0,100',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after:data_inicio',
            'id_administrador' => 'required|exists:administrador,id',
        ]);

        $promoCode->update($request->all());

        return redirect()->route('promo_codes.index')
            ->with('success', 'Promo code updated successfully!');
    }

    public function delete($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        $promoCode->delete();

        return redirect()->route('promo_codes.index')
            ->with('success', 'Promo code deleted successfully!');
    }


    public function checkPromoCode(Request $request)
    {
        $promoCode = $request->input('promotionCode');

        // Check if the promo code exists
        $promoCodeModel = PromoCode::where('codigo', $promoCode)
            ->where('data_fim', '>', now()) // Check if the promo code is active
            ->first();

        if ($promoCodeModel) {
            return response()->json(['valid' => true, 'data' => $promoCodeModel]);
        } else {
            return response()->json(['valid' => false, 'message' => 'Invalid or expired promo code.']);
        }
    }

    public function removePromoCode(Request $request)
    {
        $promoCode = $request->input('promotionCode');

        // Check if the promo code exists
        $promoCodeModel = PromoCode::where('codigo', $promoCode)
            ->where('data_fim', '>', now()) // Check if the promo code is active
            ->first();

        $request->session()->forget('promoCode');
        return response()->json(['valid' => true, 'message' => 'Promo code removed.', 'data' => $promoCodeModel]);
    }
}