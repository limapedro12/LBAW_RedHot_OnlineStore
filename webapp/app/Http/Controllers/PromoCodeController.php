<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Auth;

class PromoCodeController extends Controller
{
    public function index()
    {
        $promoCodes = PromoCode::all();
        return view('pages.adminPromoCode', ['promoCodes' => $promoCodes]);
    }

   

    public function create(Request $request)
    {
        /* Check if the codigo doesnt exist in db */
        $codigo = $request->input('codigo');

        $codigoExists = PromoCode::where('codigo', $codigo)->first();

        if ($codigoExists) {
            return redirect()->back()->withErrors(['codigo' => 'O código já existe.']);
        }
        

        $desconto = $request->input('discount');
        $desconto = $desconto / 100;
        

        $data_inicio = $request->input('data_inicio');
        $data_fim = $request->input('data_fim');

        $tempo_inicio = $request->input('tempo_inicio');
        $tempo_fim = $request->input('tempo_fim');

        $data_inicio = $data_inicio. ' ' .$tempo_inicio . ':00';
        $data_fim = $data_fim. ' ' .$tempo_fim . ':00';




        $promoCode = new PromoCode();
        $promoCode->codigo = $request->input('codigo');
        $promoCode->desconto = $desconto;
        $promoCode->data_inicio = $data_inicio;
        $promoCode->data_fim = $data_fim;
        $promoCode->id_administrador = Auth::guard('admin')->user()->id;
        $promoCode->save();


        return redirect('/adminPromoCode');
    }

    public function edit($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        return view('partials.editPromoCode', ['promoCode' => $promoCode]);
    }

    public function update(Request $request, $id)
    {
        $promoCode = PromoCode::findOrFail($id);

        if($promoCode->codigo != $request->input('codigo')){
            /* Check if the codigo doesnt exist in db */
            $codigo = $request->input('codigo');

            $codigoExists = PromoCode::where('codigo', $codigo)->first();

            if ($codigoExists) {
                return redirect()->back()->withErrors(['codigo' => 'O código já existe.']);
            }
        }



        $desconto = $request->input('discount');
        $desconto = $desconto / 100;
        

        $data_inicio = $request->input('data_inicio');
        $data_fim = $request->input('data_fim');

        $tempo_inicio = $request->input('tempo_inicio');
        $tempo_fim = $request->input('tempo_fim');

        $data_inicio = $data_inicio. ' ' .$tempo_inicio . ':00';
        $data_fim = $data_fim. ' ' .$tempo_fim . ':00';

        $promoCode->codigo = $request->input('codigo');
        $promoCode->desconto = $desconto;
        $promoCode->data_inicio = $data_inicio;
        $promoCode->data_fim = $data_fim;
        $promoCode->id_administrador = Auth::guard('admin')->user()->id;

        $promoCode->save();

        return redirect('/adminPromoCode');
        
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
            return response()->json(['valid' => false, 'message' => 'Promo Code inválido ou expirado.']);
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
        return response()->json(['valid' => true, 'message' => 'Promo Code removido.', 'data' => $promoCodeModel]);
    }
}