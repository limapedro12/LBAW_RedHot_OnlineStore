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
use App\Events\ChangePurchaseState;
use App\Events\CancelOrder;

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
        $purchase->estado = 'Pagamento Por Aprovar';
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
            $productPurchase->preco = round($product->precoatual * (1 - $product->desconto), 2);
            $productPurchase->save();
        }

        // clear cart
        ProductCart::where('id_utilizador', '=', Auth::id())->delete();

        return redirect('/')->with('success', 'Encomenda efetuada com sucesso!');
    }

    public function showOrders(int $id) : View
    {
        if (Auth::check() && Auth::id() == $id) {
            $purchases = Purchase::where('id_utilizador', '=', $id)->get();
            return view('pages.orders', ['purchases' => $purchases, 'userId' => $id]);
        } else {
            // para utilizador não autenticado
        }
    }

    public function showOrderDetails(int $userId, int $orderId) : View
    {
        // $this->authorize;

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
        // $this->authorize;

        $purchase = Purchase::findOrFail($orderId);
        $productIDs = ProductPurchase::where('id_compra', '=', $orderId)->get('id_produto');

        foreach ($productIDs as $productID) {
            $quantity = ProductPurchase::where('id_produto', '=', $productID["id_produto"])->where('id_compra', '=', $orderId)->first()->quantidade;
            $product = Product::findOrFail($productID["id_produto"]);
            $product->incrementStock($quantity);
        }

        $purchase->estado = 'Cancelada';
        // $purchase->save();

        event(new CancelOrder($purchase->id, Auth::user()->nome, $purchase->id_utilizador));

        return redirect('/users/'.$userId.'/orders/'.$orderId)->with('success', 'Encomenda cancelada com sucesso.');
    }

    public function changeState(int $userId, int $orderId, Request $request)
    {
        // $this->authorize;

        $request->validate([
            'state' => 'required|string'
        ]);

        $purchase = Purchase::findOrFail($orderId);
        $purchase->estado = $request->state;
        $purchase->save();

        event(new ChangePurchaseState($orderId, $purchase->id_utilizador, $purchase->estado));

        return redirect('/users/'.$userId.'/orders/'.$orderId)->with('success', 'Estado da encomenda alterado com sucesso.');
    }
}
