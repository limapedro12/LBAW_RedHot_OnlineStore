<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Faqs;




class FaqsController extends Controller
{
    public function listFaqs()
    {

        $faqs = Faqs::all();

        return view('pages.faqs', ['faqs' => $faqs]);
    }

    public function createFaqs(Request $request)
    {

        $faqs = new Faqs();

        $faqs->pergunta = $request->pergunta;
        $faqs->resposta = $request->resposta;
        $faqs->id_administrador = Auth::user()->id;

        $faqs->save();

        return redirect()->back();
    }

    public function updateFaqs(Request $request, $id)
    {

        $faqs = Faqs::find($id);

        $faqs->pergunta = $request->pergunta;
        $faqs->resposta = $request->resposta;
        $faqs->id_administrador = Auth::user()->id;

        $faqs->save();

        return redirect()->back();
    }

    public function deleteFaqs($id)
    {

        $faqs = Faqs::find($id);

        $faqs->delete();

        return redirect()->back();
    }
}
