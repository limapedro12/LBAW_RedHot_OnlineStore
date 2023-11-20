<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProductsController;

use App\Models\Product;
use App\Models\ProductCart;
use App\Models\ProductPurchase;

use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function showCheckoutForm() : View
    {   
        if (Auth::check()) {
            $productsCart = ProductCart::where('id_utilizador', '=', Auth::id())->get();
            $total = 0;
            foreach($productsCart as $productCart) {
                $product = Product::findOrFail($productCart->id_produto);
                $total += $productCart->quantidade * ($product->precoatual * (1 - $product->desconto));
            }
            return view('pages.checkout', ['total' => round($total, 2)]);
        } else {
            // para utilizador não autenticado
        }
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'cardNo' => 'required|integer|min:1000000000000000|max:9999999999999999',
            'cardHolder' => 'required|string',
            'cardExpiryMonth' => 'required|integer|min:1|max:12',
            'cardExpiryYear' => 'required|integer|min:23|max:99',
            'cardCVV' => 'required|integer|min:100|max:999',
            'street' => 'required|string',
            'doorNo' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'deliveryObs' => 'nullable|string'
        ]);

        error_log('request validated');

        $productsCart = ProductCart::where('id_utilizador', '=', Auth::id())->get();
        $total = 0;

        $address = $request->street . ', ' . $request->doorNo . ', ' . $request->city . ', ' . $request->country;

        foreach($productsCart as $productCart) {
            $product = Product::findOrFail($productCart->id_produto);
            
            // increment total
            $total += $productCart->quantidade * ($product->precoatual * (1 - $product->desconto));

            // decrement stock
            $product->decrementStock($productCart->quantidade);
        }

        $total = round($total, 2);

        // create and register purchase
        $purchase = new Purchase();
        $purchase->timestamp = date('Y-m-d H:i:s');
        $purchase->descricao = $address . ' --- ' . $request->deliveryObs;
        $purchase->id_utilizador = Auth::id();
        $purchase->estado = 'Pendente';
        $purchase->id_administrador = null; // para alterar no futuro
        $purchase->total = $total;
        $purchase->save();

        foreach($productsCart as $productCart) {
            $product = Product::findOrFail($productCart->id_produto);

            // associate each product with purchase
            $productPurchase = new ProductPurchase();
            $productPurchase->id_produto = $product->id;
            $productPurchase->id_compra = $purchase->id;
            $productPurchase->quantidade = $productCart->quantidade;
            $productPurchase->save();
        }

        // clear cart
        ProductCart::where('id_utilizador', '=', Auth::id())->delete();

        return redirect('/')->with('success', 'Encomenda efetuada com sucesso!');
    }
}
