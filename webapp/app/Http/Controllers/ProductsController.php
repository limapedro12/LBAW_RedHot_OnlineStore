<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $searchTemperature = 0.5;
        $searchedProducts = Product::searchProducts($stringToSearch);
        return view('pages.productsSearch', [
            'searchedString' => $stringToSearch,
            'products' => $searchedProducts,
            'discountFunction' => function($price, $discount){
                return $price * (1 - $discount);
            }
        ]);
    }

    public function filterProducts(string $filter){
        $filteredProducts = Product::filterProducts($filter);
        return view('pages.productsFilter', [
            'filter' => Product::filterToDisplay($filter),
            'products' => $filteredProducts,
            'discountFunction' => function($price, $discount){
                return $price * (1 - $discount);
            }
        ]);
    }

    public function searchAndFilterProducts(string $stringToSearch, string $filter){
        $products = Product::searchAndFilterProducts($stringToSearch, $filter);
        return view('pages.productsSearchAndFilter', [
            'searchedString' => $stringToSearch,
            'filter' => Product::filterToDisplay($filter),
            'products' => $products,
            'discountFunction' => function($price, $discount){
                return $price * (1 - $discount);
            }
        ]);
    }
}
