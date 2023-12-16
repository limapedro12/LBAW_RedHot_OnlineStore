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
use App\Models\Visit;
use App\Models\ProductCart;

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

        $sales = [Purchase::whereMonth('timestamp', '01')->get(), Purchase::whereMonth('timestamp', '02')->get(),
            Purchase::whereMonth('timestamp', '03')->get(), Purchase::whereMonth('timestamp', '04')->get(),
            Purchase::whereMonth('timestamp', '05')->get(), Purchase::whereMonth('timestamp', '06')->get(),
            Purchase::whereMonth('timestamp', '07')->get(), Purchase::whereMonth('timestamp', '08')->get(),
            Purchase::whereMonth('timestamp', '09')->get(), Purchase::whereMonth('timestamp', '10')->get(),
            Purchase::whereMonth('timestamp', '11')->get(), Purchase::whereMonth('timestamp', '12')->get()];

        $janeiro = $this->getSalesFromMonth(1); $fevereiro = $this->getSalesFromMonth(2); $marco = $this->getSalesFromMonth(3);
        $abril = $this->getSalesFromMonth(4); $maio = $this->getSalesFromMonth(5); $junho = $this->getSalesFromMonth(6);
        $julho = $this->getSalesFromMonth(7); $agosto = $this->getSalesFromMonth(8); $setembro = $this->getSalesFromMonth(9);
        $outubro = $this->getSalesFromMonth(10); $novembro = $this->getSalesFromMonth(11); $dezembro = $this->getSalesFromMonth(12);

        $janeiroMoney = $this->getMoneyFromMonth(1); $fevereiroMoney = $this->getMoneyFromMonth(2); $marcoMoney = $this->getMoneyFromMonth(3);
        $abrilMoney = $this->getMoneyFromMonth(4); $maioMoney = $this->getMoneyFromMonth(5); $junhoMoney = $this->getMoneyFromMonth(6);
        $julhoMoney = $this->getMoneyFromMonth(7); $agostoMoney = $this->getMoneyFromMonth(8); $setembroMoney = $this->getMoneyFromMonth(9);
        $outubroMoney = $this->getMoneyFromMonth(10); $novembroMoney = $this->getMoneyFromMonth(11); $dezembroMoney = $this->getMoneyFromMonth(12);

        $yearLabels = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

        $monthLabels = ['1', '2', '3', '4', '5', '6', '7','8','9','10','11','12','13','14','15','16','17','18','19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29','30','31'];

        return view('pages.admin', [
            'sales' => $sales,
            'janeiro' => $janeiro, 'fevereiro' => $fevereiro, 'marco' => $marco, 'abril' => $abril, 'maio' => $maio, 'junho' => $junho,
            'julho' => $julho,'agosto' => $agosto,'setembro' => $setembro,'outubro' => $outubro,'novembro' => $novembro,'dezembro' => $dezembro,
            'janeiroMoney' => $janeiroMoney, 'fevereiroMoney' => $fevereiroMoney, 'marcoMoney' => $marcoMoney, 'abrilMoney' => $abrilMoney, 'maioMoney' => $maioMoney, 'junhoMoney' => $junhoMoney,
            'julhoMoney' => $julhoMoney,'agostoMoney' => $agostoMoney,'setembroMoney' => $setembroMoney,'outubroMoney' => $outubroMoney,'novembroMoney' => $novembroMoney,'dezembroMoney' => $dezembroMoney,
            'yearLabels' => $yearLabels,
            'monthLabels' => $monthLabels,
            'visitsLast30Days' => $this->getNumberOfVisitsInLast30Days(),
            'listVisits' => Visit::all(),
            'activeShoppingCarts' => $this->getActiveShoppingCarts()
        ]);
    }

    public function getSalesFromMonth($month)
    {
        $monthSales = [];
        for ($day = 0; $day <= 30; $day++) {
            $numberSales = Purchase::whereMonth('timestamp', $month)
                ->whereDay('timestamp', $day)
                ->count();

            $monthSales[$day] = $numberSales;
        }

        return $monthSales;
    }

    public function getMoneyFromMonth($month)
    {
        $monthSales = [];
        for ($day = 0; $day <= 30; $day++) {
            $numberSales = Purchase::whereMonth('timestamp', $month)
                ->whereDay('timestamp', $day)
                ->sum('total');

            $monthSales[$day] = $numberSales;
        }

        return $monthSales;
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

    public function getNumberOfVisitsInLast30Days()
    {

        $visits = Visit::where('timestamp', '>', now()->subDays(30))->get();

        return $visits->count();
    }

    public function getActiveShoppingCarts(){
        
        return ProductCart::select('id_utilizador')->where('timestamp', '>', now()->subDays(30))->groupBy('id_utilizador')->get()->count();

    }

}
