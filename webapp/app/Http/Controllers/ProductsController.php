<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;

class ProductsController extends Controller {
    public function list()
    {
        
        return view('pages.products', [
            'produtos' => Product::all()
        ]);
    }
}
