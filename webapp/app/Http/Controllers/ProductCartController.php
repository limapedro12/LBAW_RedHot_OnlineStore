<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\PromoCodeController;
use App\Http\Controllers\ProductsController;

use App\Models\Product;
use App\Models\ProductCart;
use App\Models\PromoCode;

class ProductCartController extends Controller
{
    public function addToCart(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'quantidade' => 'required|integer|min:1'
        ]);

        if ($request->quantidade > $product->stock) {
            return back()->withErrors(['quantity' => 'A quantidade escolhida super o stock disponível.']);
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
            if (!session('guestID'))
                session(['guestID' => self::getNewGuestId()]);

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

        sleep(1.7);

        return redirect('/products/' . $id);
    }

    public function removeFromCart(Request $request)
    {
        ProductCart::where(['id_utilizador' => Auth::id(), 'id_produto' => $request->id_produto])->delete();

        return redirect('/cart');
    }

    public static function getNewGuestId()
    {
        $guestID = ProductCart::max('id_utilizador') + 1;
        return $guestID;
    }

    public function showCart(): View
    {
        $productsCart = null;
        if (Auth::check()) {
            $productsCart = ProductCart::where('id_utilizador', '=', Auth::id())->get();
        } else {
            if (!session('guestID')) {
                session(['guestID' => self::getNewGuestId()]);
                $productsCart = [];
            } else {
                $productsCart = ProductCart::where('id_utilizador_nao_autenticado', '=', session('guestID'))->get();
            }
        }

        $quantityProductList = [];
        $allProducts= [];
        $subTotal = 0;
        foreach ($productsCart as $productCart) {
            $product = Product::findOrFail($productCart->id_produto);
            $allProducts[] = $product;
            $quantityProductList[] = [$productCart->quantidade, $product];
            $subTotal += $productCart->quantidade * ($product->precoatual * (1 - $product->desconto));
        }

        $userEnteredPromoCode = request()->input('promotionCode');

        // Get the promo code information based on the user input
        $promotionCode = PromoCode::where('codigo', $userEnteredPromoCode)
        ->where('data_inicio', '<=', now())
        ->where('data_fim', '>', now())
        ->first();

        session(['promotionCode' => $promotionCode]);
    

        return view('pages.cart', [
            'list' => $quantityProductList,
            'discountFunction' => function ($price, $discount) {
                return $price * (1 - $discount);
            },
            'subTotal' => round($subTotal, 2),
            'promotionCode' => $promotionCode,
            'similarProducts' => $this->getSimilarProducts($allProducts)
        ]);

    }

    public static function transferGuestCart(int $guestId)
    {
        ProductCart::where('id_utilizador', '=', Auth::id())->delete();

        $productsCart = ProductCart::where('id_utilizador_nao_autenticado', '=', $guestId)->get();

        foreach ($productsCart as $productCart) {
            $productCart->id_utilizador_nao_autenticado = null;
            $productCart->id_utilizador = Auth::id();
            $productCart->save();
        }
    }

    public function getSimilarProducts(array $allProducts)
    {
        $arrSimilarProducts = [];
        foreach ($allProducts as $product) {
            $arrSimilarProducts[] = Product::where('categoria', '=', $product->categoria)->get();
        }

        $similarProducts = [];

        foreach( $arrSimilarProducts as $arrProducts) {
            foreach ($arrProducts as $product) {
                if (!in_array($product, $similarProducts) && !in_array($product, $allProducts)) {
                    $similarProducts[] = $product;
                }
            }            
        }

        /* Clean the duplicated products */
        $similarProducts = array_unique($similarProducts);

        
        if (count($similarProducts) < 5){ 
            return $similarProducts;
        }
        else {
            /* Select random 5 */
            $randomKeys = array_rand($similarProducts, 5);
            $randomProducts = [];
            foreach ($randomKeys as $key) {
                $randomProducts[] = $similarProducts[$key];
            }
            return $randomProducts;
        }
    }

}
