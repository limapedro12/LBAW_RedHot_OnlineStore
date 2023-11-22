<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\ProductPurchase;

use App\Policies\UserPolicy;
use App\Policies\AdminPolicy;

function verifyAdmin() : void {
    if(Auth::guard('admin')->user()==null)
        abort(403);
}

class AdminController extends Controller{

    public function admin(){
        verifyAdmin();

        $sales = [];
        
        $sales["count"] = Purchase::count();
        
        if ($sales["count"] == 0) {
            $sales["avg"] = 0;
            $sales["total"] = 0;
        } else {
            $sales["total"] = Purchase::sum('total');
            $sales["avg"] = $sales["total"] / $sales["count"];
        }

        //$most_sold_id = ProductPurchase::select('id_produto')->groupBy('id_produto')->orderBy('quantidade', 'desc')->first();

        //$most_sold = Product::find($most_sold_id);

        return view('pages.admin', [
                'sales' => $sales//,
                //'most_sold' => $most_sold
        ]);
    }
    
    public function adminOrders(){
        verifyAdmin();

        $orders = Purchase::all();

        return view('pages.adminOrders', [
            'orders' => $orders
        ]);
    }
    
    public function adminProducts(){
        verifyAdmin();
        return view('pages.adminProductsManage', [
            'products' => Product::all(),
            'discountFunction' => function($price, $discount){
                return $price * (1 - $discount);
            }
        ]);
    }
    
    public function adminProductsDiscounts(){
        verifyAdmin();
        return view('pages.adminProductsDiscounts');
    }
    
    public function adminProductsHighlights(){
        verifyAdmin();
        return view('pages.adminProductsHighlights');
    }
    
    public function adminProductsManage(){
        verifyAdmin();
        return view('pages.adminProductsManage', [
            'products' => Product::all(),
            'discountFunction' => function($price, $discount){
                return $price * (1 - $discount);
            }
        ]);
    }
    
    public function adminShipping(){
        verifyAdmin();
        return view('pages.adminShipping');
    }
    
    public function adminUsers(){
        verifyAdmin();
        return view('pages.adminUsers');
    }

}