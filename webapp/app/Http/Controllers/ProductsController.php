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
            'filterArr' => Product::filterToArray($filter),
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
            'filterArr' => Product::filterToArray($filter),
            'products' => $products,
            'discountFunction' => function($price, $discount){
                return $price * (1 - $discount);
            }
        ]);
    }

    public function addProductForm(){
        return view('pages.productsAdd');
    }

    public function addProduct(Request $request){
        $request->validate([
            'name' => 'required|string|max:256',
            'price' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'description' => 'required|string|max:256',
            'url_image' => 'required|string|max:256',
        ]);

        $newProduct = Product::create([
            'nome' => $request->name,
            'precoatual' => 20,
            'desconto' => $request->discount,
            'stock' => $request->stock,
            'id_administrador' => 1,
            'descricao' => $request->description,
            'url_imagem' => $request->url_image,
        ]);

        return redirect('/products/'.$newProduct->id);
    }

    public function editProductForm(int $id){
        return view('pages.productsEdit', [
            'product' => Product::findorfail($id),
        ]);
    }

    public function editProduct(Request $request, int $id){
        $request->validate([
            'name' => 'required|string|max:256',
            'price' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'description' => 'required|string|max:256',
            'url_image' => 'required|string|max:256',
        ]);

        Product::where('id', '=', $id)->update(array('nome' => $request->name, 
                                                     'precoatual' => $request->price, 
                                                     'desconto' => $request->discount, 
                                                     'stock' => $request->stock, 
                                                     'descricao' => $request->description, 
                                                     'url_imagem' => $request->url_image));

        return redirect('/products/'.$id);
    }
}
