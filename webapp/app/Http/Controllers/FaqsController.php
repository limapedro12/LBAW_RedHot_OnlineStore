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
        $faqs->id_administrador = Auth::guard('admin')->user()->id;

        $faqs->save();

        return redirect('/adminFAQ');
    }

    public function editFaqs(Request $request, $id)
    {
        $faqs = Faqs::find($id);

        $faqs->pergunta = $request->pergunta;
        $faqs->resposta = $request->resposta;
        $faqs->id_administrador = Auth::guard('admin')->user()->id;

        $faqs->save();

        return redirect()->back();
    }

    public function deleteFaqs($id)
    {
        $faqs = Faqs::find($id);

        $faqs->delete();

        return redirect()->back();
    }

    public function faq($id)
    {
        $faq = Faqs::find($id);

        return view('partials.faq', ['faq' => $faq]);
    }

    public function addFaqForm()
    {
        return view('pages.adminFAQAdd');
    }
}
