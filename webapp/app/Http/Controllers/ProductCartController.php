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
            if (!session('guestID')) session(['guestID'=> self::getNewGuestId()]);

            $productCart = ProductCart::where('id_produto', '=', $id)->where('id_utilizador_nao_autenticado', '=', session('guestID'))->first();

            if ($productCart) {
                $productCart->quantidade += $request->quantidade;
                $productCart->save();
            } else {
                ProductCart::create([
                    'id_produto' => $id,
                    'id_utilizador_nao_autenticado' => session('guestID'),
                    'quantidade' => $request->quantidade
                ]);
            }
        }

        return redirect('/products/'.$id);
    }

    public function removeFromCart(Request $request)
    {
        ProductCart::where(['id_utilizador' => Auth::id(),'id_produto' => $request->id_produto])->delete();
        
        return redirect('/cart');
    }

    public static function getNewGuestId() {
        $guestID = ProductCart::max('id_utilizador') + 1;
        return $guestID;
    }

    public function showCart() : View
    {
        $productsCart = null;
        if (Auth::check()) {
            $productsCart = ProductCart::where('id_utilizador', '=', Auth::id())->get();
        } else {
            if (!session('guestID')) {
                session(['guestID'=> self::getNewGuestId()]);
                $productsCart = [];
            } else {
                $productsCart = ProductCart::where('id_utilizador_nao_autenticado', '=', session('guestID'))->get();
            }
        }

        $quantityProductList = [];
        $total = 0;
        foreach($productsCart as $productCart) {
            $product = Product::findOrFail($productCart->id_produto);
            $quantityProductList[] = [$productCart->quantidade, $product];
            $total += $productCart->quantidade * ($product->precoatual * (1 - $product->desconto));
        }

        return view('pages.cart', ['list' => $quantityProductList,
                                      'discountFunction' => function($price, $discount) {
                                                            return $price * (1 - $discount);},
                                      'total' => round($total, 2)]);
    }

    public static function transferGuestCart(int $guestId) {
        ProductCart::where('id_utilizador', '=', Auth::id())->delete();

        $productsCart = ProductCart::where('id_utilizador_nao_autenticado', '=', $guestId)->get();

        foreach ($productsCart as $productCart) {
            $productCart->id_utilizador_nao_autenticado = null;
            $productCart->id_utilizador = Auth::id();
            $productCart->save();
        }
    }
}
