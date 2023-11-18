<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;


class ProductsController extends Controller {
    public function productsDetails(int $id){
        return view('pages.productDetails', [
            'product' => Product::findorfail($id),
            'discountFunction' => function($price, $discount){
                return $price * (1 - $discount);
            }
        ]);
    }

    public function listProducts(){
        return view('pages.products', [
            'products' => Product::all(),
            'discountFunction' => function($price, $discount){
                return $price * (1 - $discount);
            }
        ]);
    }

    public function searchProducts(string $stringToSearch){
        $searchedProducts = DB::table('produto')
                            ->selectRaw("ts_rank(tsvectors, plainto_tsquery('portuguese', ?))", [$stringToSearch])
                            ->get();

        return view('pages.productsSearch', [
            'products' => $searchedProducts,
            'discountFunction' => function($price, $discount){
                return $price * (1 - $discount);
            }
        ]);
    }
}
