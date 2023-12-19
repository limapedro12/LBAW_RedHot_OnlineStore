<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProductsController;

use App\Models\Product;
use App\Models\ProductCart;
use App\Models\ProductPurchase;
use App\Models\PromoCode;

use App\Models\Purchase;
use App\Events\ChangePurchaseState;
use App\Events\CancelOrder;

class PurchaseController extends Controller
{
    public function showCheckoutForm(Request $request)
    {
        if (Auth::check()) {
            $productsCart = ProductCart::where('id_utilizador', '=', Auth::id())->get();
            $subTotal = 0;
            $total = 0;
            foreach ($productsCart as $productCart) {
                $product = Product::findOrFail($productCart->id_produto);
                $subTotal += $productCart->quantidade * ($product->precoatual * (1 - $product->desconto));
            }

            if ($request->input('promocode')) {
                $promoCode = PromoCode::where('codigo', $request->input('promocode'))
                    ->where('data_inicio', '<=', now())
                    ->where('data_fim', '>', now())
                    ->first();
    
                if ($promoCode) {
                    $total = $subTotal * (1 - $promoCode->desconto);
                }
            }

            
            if($request->input('promocode')){
                return view('pages.checkout', [
                    'subTotal' => round($subTotal, 2),
                    'total' => round($total, 2),
                    'productsCart' => $productsCart,
                    'promotionCode' => $promoCode
                ]);
            }
            else{
                return view('pages.checkout', [
                    'subTotal' => round($subTotal, 2),
                    'total' => round($subTotal, 2),
                    'productsCart' => $productsCart,
                    'promotionCode' => null
                ]);
            }
        } else {
            return redirect('/login')->withErrors([
                'password' => 'Por favor, autentique-se na RedHot para prosseguir com a sua encomenda.',
            ]);
        }
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|integer',
            'nif' => 'nullable|integer',
            'street' => 'required|string',
            'doorNo' => 'required|string',
            'floor' => 'nullable|string',
            'postalCode' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'deliveryObs' => 'nullable|string'
        ]);

        $metodoPagamento = $request->paymentMethod;

        switch ($request->paymentMethod) {
            case 'card':
                if ($request->cardNo < 3000000000000000 || $request->cardNo > 9999999999999999)
                    return back()->withErrors(['cardNo' => 'Número de cartão inválido.']);

                if ($request->cardExpiryMonth < 1 || $request->cardExpiryMonth > 12)
                    return back()->withErrors(['cardExpiryMonth' => 'Por favor introduza um mês entre 1 e 12.']);

                if ($request->cardExpiryYear < 23)
                    return back()->withErrors(['cardExpirtyMonth' => 'Ano de expiração inválido.']);

                if ($request->cardCVV < 100 || $request->cardCVV > 999)
                    return back()->withErrors(['cardCVV' => 'CVV inválido. O CVV é um código de três dígitos que se encontra nas traseiras do seu cartão bancário.']);
                break;
            case 'mbway':
                if ($request->mbwayNo < 910000000 || $request->mbwayNo > 969999999)
                    return back()->withErrors(['mbwayNo' => 'Número de telemóvel inválido.']);
                break;
        }

        $productsCart = ProductCart::where('id_utilizador', '=', Auth::id())->get();
        $total = 0;
        $subTotal = 0;

        $address = $request->street . ', ' . $request->doorNo . ', ' . $request->city . ', ' . $request->country;

        foreach ($productsCart as $productCart) {
            $product = Product::findOrFail($productCart->id_produto);

            // increment total
            $total += $productCart->quantidade * ($product->precoatual * (1 - $product->desconto));

            // decrement stock
            $product->decrementStock($productCart->quantidade);
        }

        $subTotal = $total;
        $subTotal = round($subTotal, 2);

        // apply promo code
        if ($request->input('promocode')) {
            $promoCode = PromoCode::where('codigo', $request->input('promocode'))
                ->where('data_inicio', '<=', now())
                ->where('data_fim', '>', now())
                ->first();

            if ($promoCode) {
                $total *= (1 - $promoCode->desconto);
            }
        }


        $total = round($total, 2);

        // create and register purchase
        $purchase = new Purchase();
        $purchase->timestamp = date('Y-m-d H:i:s');
        $purchase->descricao = $request->deliveryObs;
        $purchase->id_utilizador = Auth::id();
        $purchase->sub_total = $subTotal;
        if ($request->input('promocode'))
            $purchase->id_promo_code = $promoCode->id;
        switch ($request->paymentMethod) {
            case 'card':
            case 'mbway':
                $purchase->estado = 'Pagamento por Aprovar';
                break;
            case 'cash':
                $purchase->estado = 'Em processamento';
                break;
        }
        $purchase->id_administrador = null;
        $purchase->total = $total;
        $purchase->first_name = $request->firstName;
        $purchase->last_name = $request->lastName;
        $purchase->email = $request->email;
        $purchase->morada = $request->street;
        $purchase->porta = $request->doorNo;
        $purchase->andar = $request->floor;
        $purchase->codigo_postal = $request->postalCode;
        $purchase->localidade = $request->city;
        $purchase->telefone = $request->phone;
        $purchase->nif = $request->nif;
        $purchase->pais = $request->country;
        $purchase->metodo_pagamento = $metodoPagamento;
        $purchase->save();

        foreach ($productsCart as $productCart) {
            $product = Product::findOrFail($productCart->id_produto);

            // associate each product with purchase
            $productPurchase = new ProductPurchase();
            $productPurchase->id_produto = $product->id;
            $productPurchase->id_compra = $purchase->id;
            $productPurchase->quantidade = $productCart->quantidade;
            $productPurchase->preco = round($product->precoatual * (1 - $product->desconto), 2);
            $productPurchase->save();
        }

        // clear cart
        ProductCart::where('id_utilizador', '=', Auth::id())->delete();

        return redirect('/users/' . Auth::id())->with('success', 'Encomenda efetuada com sucesso!');
    }

    public function showOrders(int $id): View
    {
        if (Auth::check() && Auth::id() == $id) {
            $purchases = Purchase::where('id_utilizador', '=', $id)->get();
            return view('pages.orders', ['purchases' => $purchases, 'userId' => $id]);
        }
        abort(403);
    }

    public function showOrderDetails(int $userId, int $orderId): View
    {
        $purchase = Purchase::findOrFail($orderId);
        $productIDs = ProductPurchase::where('id_compra', '=', $orderId)->get('id_produto');
        $quantPriceProducts = [];

        foreach ($productIDs as $productID) {
            $quantity = ProductPurchase::where('id_produto', '=', $productID["id_produto"])->where('id_compra', '=', $orderId)->first()->quantidade;
            $price = ProductPurchase::where('id_produto', '=', $productID["id_produto"])->where('id_compra', '=', $orderId)->first()->preco;
            $product = Product::findOrFail($productID["id_produto"]);
            $quantPriceProducts[] = [$quantity, $price, $product];
        }

        $all_states = ['Em processamento', 'Pagamento por Aprovar', 'Pagamento Aprovado', 'Pagamento Não Aprovado', 'Enviada', 'Entregue', 'Cancelada'];

        return view('pages.orderDetails',
            ['purchase' => $purchase,
                'quantPriceProducts' => $quantPriceProducts,
                'remainingStates' => array_values(array_diff($all_states, [$purchase->estado])),
            ]);
    }

    public function cancelOrder(int $userId, int $orderId)
    {
        $purchase = Purchase::findOrFail($orderId);

        if (
            $purchase->estado == 'Enviada' ||
            $purchase->estado == 'Entregue' ||
            $purchase->estado == 'Cancelada' ||
            Auth::user()->id != $userId
        )
            abort(403);

        $productIDs = ProductPurchase::where('id_compra', '=', $orderId)->get('id_produto');

        foreach ($productIDs as $productID) {
            $quantity = ProductPurchase::where('id_produto', '=', $productID["id_produto"])->where('id_compra', '=', $orderId)->first()->quantidade;
            $product = Product::findOrFail($productID["id_produto"]);
            $product->incrementStock($quantity);
        }

        $purchase->estado = 'Cancelada';
        $purchase->save();

        event(new CancelOrder($purchase->id, Auth::user()->nome, $purchase->id_utilizador));

        sleep(1);

        return redirect('/users/' . $userId . '/orders/' . $orderId)->with('success', 'Encomenda cancelada com sucesso.');
    }

    public function changeState(int $userId, int $orderId, Request $request)
    {
        if (!Auth::guard('admin')->check())
            abort(403);
        $request->validate([
            'state' => 'required|string'
        ]);

        $purchase = Purchase::findOrFail($orderId);
        $purchase->estado = $request->state;
        $purchase->save();

        event(new ChangePurchaseState($orderId, $purchase->id_utilizador, $purchase->estado));

        return redirect('/users/' . $userId . '/orders/' . $orderId)->with('success', 'Estado da encomenda alterado com sucesso.');
    }

    public function setQuantity(int $productId, int $newQuantity){
        $product = Product::findOrFail($productId);
        if ($newQuantity <= $product->stock){
            $productCart = ProductCart::where('id_utilizador', '=', Auth::id())->where('id_produto', '=', $productId)->first();
            $productCart->quantidade = $newQuantity;
            $productCart->save();
        }
    }

    public function decreaseQuantity(int  $productId){
        $productCart = ProductCart::where('id_utilizador', '=', Auth::id())->where('id_produto', '=',  $productId)->first();
        if ($productCart->quantidade > 1) {
            $productCart->quantidade -= 1;
            $productCart->save();
        } else {
            $productCart->delete();
        }
    }

    public function increaseQuantity(int  $productId){
        $productCart = ProductCart::where('id_utilizador', '=', Auth::id())->where('id_produto', '=',  $productId)->first();
        $product = Product::findOrFail( $productId);
        if ($productCart->quantidade < $product->stock) {
            $productCart->quantidade += 1;
            $productCart->save();
        }
    }
}

