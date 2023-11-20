<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin;
use App\Policies\UserPolicy;
use App\Policies\AdminPolicy;

function verifyAdmin() : void {
    if(Auth::guard('admin')->user()==null)
        abort(403);
}

class AdminController extends Controller{

    public function admin(){
        verifyAdmin();
        return view('pages.admin');
    }
    
    public function adminOrders(){
        verifyAdmin();
        return view('pages.adminOrders');
    }
    
    public function adminProducts(){
        verifyAdmin();
        return view('pages.adminProducts');
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
        return view('pages.adminProductsManage');
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