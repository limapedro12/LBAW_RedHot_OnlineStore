<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\ProductCart;

use App\Events\ChangeInProductsPrice;

use App\Http\Controllers\FileController;

function verifyAdmin() : void {
    if(Auth::guard('admin')->user()==null)
        abort(403);
}

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
            'maxPrice' => Product::getMostExpensiveProductPrice(),
            'products' => Product::orderBy('id')->get(),
            'discountFunction' => function($price, $discount){
                return $price * (1 - $discount);
            },
            'allCategories' => Product::getAllCategories()
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

    public function searchAndFilterProductsAPI(string $stringToSearch, string $filter){
        if($stringToSearch == '*')
            $products = Product::filterProducts($filter);
        else
            $products = Product::searchAndFilterProducts($stringToSearch, $filter);
        return json_encode($products);
    }

    public function addProductForm(){
        verifyAdmin();
        return view('pages.productsAdd');
    }

    public function addProduct(Request $request) {
        verifyAdmin();

        $request->validate([
            'name' => 'required|string|max:256',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:1',
            'stock' => 'required|numeric|min:0',
            'description' => 'required|string|max:256',
            'category' => 'nullable|string|max:256',
        ]);

        $newProduct = Product::create([
            'nome' => $request->name,
            'precoatual' => $request->price,
            'desconto' => ($request->discount? $request->discount : 0),
            'stock' => $request->stock,
            'id_administrador' => 1,
            'descricao' => $request->description,
            'categoria' => strtolower($request->category),
        ]);

        if ($request->file) {
            $fileController = new FileController();
            $hash = $fileController->upload($request, 'product', $newProduct->id);
            $newProduct->update(array('product_image' => $hash));
        }

        return redirect('/products/'.$newProduct->id);
    }

    public function editProductForm(int $id){
        verifyAdmin();

        return view('pages.productsEdit', [
            'product' => Product::findorfail($id),
        ]);
    }

    public function editProduct(Request $request, int $id){
        verifyAdmin();
        
        $request->validate([
            'name' => 'required|string|max:256',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'description' => 'required|string|max:256',
            'category' => 'string|max:256',
        ]);

        $oldProduct = Product::findorfail($id);
        if($oldProduct->precoatual != $request->price || $oldProduct->desconto != $request->discount){
            $usersWithProductInCart = ProductCart::where('id_produto', '=', $id)->get();
            foreach($usersWithProductInCart as $userWithProductInCart)
                event(new ChangeInProductsPrice($userWithProductInCart->id_utilizador, 
                                                $oldProduct->id, $oldProduct->nome, 
                                                $oldProduct->precoatual*(1-$oldProduct->desconto), 
                                                $request->price*(1-$request->discount)));
        }
        
        if ($request->file && !($request->deletePhoto)) {
            $fileController = new FileController();
            $hash = $fileController->upload($request, 'product', $id);
            Product::where('id', '=', $id)->update(array('product_image' => $hash));
        } else if ($request->deletePhoto) {
            Product::where('id', '=', $id)->update(array('product_image' => null));
        }

        Product::where('id', '=', $id)->update(array('nome' => $request->name, 
                                                     'precoatual' => $request->price, 
                                                     'desconto' => $request->discount, 
                                                     'stock' => $request->stock, 
                                                     'descricao' => $request->description,
                                                     'categoria' => strtolower($request->category)));

        return redirect('/products/'.$id);
    }

    public function changeStockProductForm(int $id){
        verifyAdmin();

        return view('pages.productsChangeStock', [
            'product' => Product::findorfail($id),
        ]);
    }

    public function changeStockProduct(Request $request, int $id){
        verifyAdmin();
        
        $request->validate([
            'stock' => 'required|numeric|min:0',
        ]);

        Product::where('id', '=', $id)->update(array('stock' => $request->stock));

        return redirect('/products/'.$id);
    }

    function deleteProduct(Request $request, int $id){
        verifyAdmin();
        $product = Product::where('id', '=', $id);
        FileController::delete($product->product_image);
        $product->delete();
        return redirect('/adminProductsManage');
    }
}
