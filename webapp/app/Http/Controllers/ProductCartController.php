<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\ProductCart;

class ProductCartController extends Controller
{
    public function addToCart(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'quantidade' => 'required|integer|min:1'
        ]);

        if ($request->quantidade > $product->stock) {
            return redirect('/products/'.$id);
        }

        if (Auth::check()) {
            $productCart = ProductCart::where('id_produto', '=', $id)->where('id_utilizador', '=', Auth::id())->first();
            if ($productCart) {
                $productCart->quantidade += $request->quantidade;
                $productCart->save();
            } else {
                ProductCart::create([
                    'id_produto' => $id,
                    'id_utilizador' => Auth::id(),
                    'quantidade' => $request->quantidade
                ]);
            }
        } else {
            // para utilizador não autenticado
        }

        return redirect('/products/'.$id);
    }

    public function removeFromCart(Request $request)
    {
        ProductCart::where(['id_utilizador' => Auth::id(),'id_produto' => $request->id_produto])->delete();
        
        return redirect('/cart');
    }

    public function showCart() : View
    {
        if (Auth::check()) {
            $productsCart = ProductCart::where('id_utilizador', '=', Auth::id())->get();
            $quantityProductList = [];
            foreach($productsCart as $productCart) {
                $quantityProductList[] = [$productCart->quantidade, Product::findOrFail($productCart->id_produto)];
            }
            return view('pages.cart', ['list' => $quantityProductList,
                                      'discountFunction' => function($price, $discount) {
                                                            return $price * (1 - $discount);}]);
        } else {
            // para utilizador não autenticado
        }
    }
}

// agora é calcular o total