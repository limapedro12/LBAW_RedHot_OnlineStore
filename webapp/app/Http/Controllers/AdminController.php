<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\User;
use App\Models\Faqs;

use App\Policies\UserPolicy;
use App\Policies\AdminPolicy;

function verifyAdmin(): void
{
    if (Auth::guard('admin')->user() == null)
        abort(403);
}

class AdminController extends Controller
{

    public function admin()
    {
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
            'sales' => $sales //,
            //'most_sold' => $most_sold
        ]);
    }

    public function adminNotifications()
    {
        verifyAdmin();
        return view('pages.adminNotifications');
    }

    public function adminOrders()
    {
        verifyAdmin();

        $orders = Purchase::all()->sortByDesc('timestamp');

        return view('pages.adminOrders', [
            'orders' => $orders
        ]);
    }

    public function adminProducts()
    {
        verifyAdmin();
        return view('pages.adminProductsManage', [
            'products' => Product::orderBy('id')->get(),
            'discountFunction' => function ($price, $discount) {
                return $price * (1 - $discount);
            }
        ]);
    }

    public function adminProductsAdd()
    {
        verifyAdmin();
        return view('pages.adminProductsAdd');
    }

    public function adminProductsHighlights()
    {
        verifyAdmin();

        return view('pages.adminProductsHighlights', [
            'destaques' => Product::where('destaque', 1)->get(),
            'restantesProdutos' => Product::where('destaque', 0)->get(),
            'discountFunction' => function ($price, $discount) {
                return $price * (1 - $discount);
            }
        ]);
    }

    public function addHighlight($id)
    {
        verifyAdmin();

        $product = Product::find($id);

        $product->destaque = 1;

        $product->save();

        return redirect('/adminProductsHighlights');
    }

    public function removeHighlight($id)
    {
        verifyAdmin();

        $product = Product::find($id);

        $product->destaque = 0;

        $product->save();

        return redirect('/adminProductsHighlights');
    }

    public function adminProductsManage()
    {
        verifyAdmin();
        return view('pages.adminProductsManage', [
            'products' => Product::orderBy('id')->get(),
            'discountFunction' => function ($price, $discount) {
                return $price * (1 - $discount);
            }
        ]);
    }

    public function adminProfile()
    {
        verifyAdmin();
        return view('pages.adminProfile');
    }

    public function adminShipping()
    {
        verifyAdmin();
        return view('pages.adminShipping');
    }

    public function adminUsers()
    {
        verifyAdmin();
        return view('pages.adminUsers', [
            'users' => User::all()
        ]);
    }

    public function adminFAQ()
    {
        verifyAdmin();
        return view('pages.adminFAQ', [
            'faqs' => Faqs::all()
        ]);
    }

    public static function verifyAdmin2(): void
    {
        if (Auth::guard('admin')->user() == null)
            abort(403);
    }
}
