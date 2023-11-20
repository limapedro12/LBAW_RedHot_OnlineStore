<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\ProductCart;

class ProductCartController extends Controller
{
    public function addToCart(Request $request, int $id) {
        $product = Product::findOrFail($id);

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($request->quantity > $product->stock) {
            return redirect('/products/'.$id);
        }

        if (Auth::check()) {
            $productCart = ProductCart::where('id_produto', '=', $id)->where('id_utilizador', '=', Auth::id())->first();
            if ($productCart) {
                $productCart->quantidade += $request->quantity;
                $productCart->save();
            } else {
                ProductCart::create([
                    'id_produto' => $id,
                    'id_utilizador' => Auth::id(),
                    'quantidade' => $request->quantity
                ]);
            }
        } else {
            // para utilizador não autenticado
        }

        return redirect('/products/'.$id);
    }
}
