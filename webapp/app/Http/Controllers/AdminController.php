<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\Admin;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\User;
use App\Models\Faqs;
use App\Models\Visit;
use App\Models\ProductCart;
use App\Models\PromoCode;

use App\Http\Controllers\FileController;

use App\Policies\UserPolicy;
use App\Policies\AdminPolicy;

function verifyAdmin(): void
{
    if (Auth::guard('admin')->user() == null)
        abort(403);
}

class AdminController extends Controller
{

    public function admin(): View
    {
        verifyAdmin();

        $sales = [Purchase::whereMonth('timestamp', '01')->get(), Purchase::whereMonth('timestamp', '02')->get(),
            Purchase::whereMonth('timestamp', '03')->get(), Purchase::whereMonth('timestamp', '04')->get(),
            Purchase::whereMonth('timestamp', '05')->get(), Purchase::whereMonth('timestamp', '06')->get(),
            Purchase::whereMonth('timestamp', '07')->get(), Purchase::whereMonth('timestamp', '08')->get(),
            Purchase::whereMonth('timestamp', '09')->get(), Purchase::whereMonth('timestamp', '10')->get(),
            Purchase::whereMonth('timestamp', '11')->get(), Purchase::whereMonth('timestamp', '12')->get()];

        $janeiro = $this->getSalesFromMonth(1);
        $fevereiro = $this->getSalesFromMonth(2);
        $marco = $this->getSalesFromMonth(3);
        $abril = $this->getSalesFromMonth(4);
        $maio = $this->getSalesFromMonth(5);
        $junho = $this->getSalesFromMonth(6);
        $julho = $this->getSalesFromMonth(7);
        $agosto = $this->getSalesFromMonth(8);
        $setembro = $this->getSalesFromMonth(9);
        $outubro = $this->getSalesFromMonth(10);
        $novembro = $this->getSalesFromMonth(11);
        $dezembro = $this->getSalesFromMonth(12);

        $janeiroMoney = $this->getMoneyFromMonth(1);
        $fevereiroMoney = $this->getMoneyFromMonth(2);
        $marcoMoney = $this->getMoneyFromMonth(3);
        $abrilMoney = $this->getMoneyFromMonth(4);
        $maioMoney = $this->getMoneyFromMonth(5);
        $junhoMoney = $this->getMoneyFromMonth(6);
        $julhoMoney = $this->getMoneyFromMonth(7);
        $agostoMoney = $this->getMoneyFromMonth(8);
        $setembroMoney = $this->getMoneyFromMonth(9);
        $outubroMoney = $this->getMoneyFromMonth(10);
        $novembroMoney = $this->getMoneyFromMonth(11);
        $dezembroMoney = $this->getMoneyFromMonth(12);

        $yearLabels = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

        $monthLabels = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'];

        return view('pages.admin', [
            'sales' => $sales,
            'janeiro' => $janeiro, 'fevereiro' => $fevereiro, 'marco' => $marco, 'abril' => $abril, 'maio' => $maio, 'junho' => $junho,
            'julho' => $julho, 'agosto' => $agosto, 'setembro' => $setembro, 'outubro' => $outubro, 'novembro' => $novembro, 'dezembro' => $dezembro,
            'janeiroMoney' => $janeiroMoney, 'fevereiroMoney' => $fevereiroMoney, 'marcoMoney' => $marcoMoney, 'abrilMoney' => $abrilMoney, 'maioMoney' => $maioMoney, 'junhoMoney' => $junhoMoney,
            'julhoMoney' => $julhoMoney, 'agostoMoney' => $agostoMoney, 'setembroMoney' => $setembroMoney, 'outubroMoney' => $outubroMoney, 'novembroMoney' => $novembroMoney, 'dezembroMoney' => $dezembroMoney,
            'yearLabels' => $yearLabels,
            'monthLabels' => $monthLabels,
            'visitsLast30Days' => $this->getNumberOfVisitsInLast30Days(),
            'listVisits' => Visit::all(),
            'activeShoppingCarts' => $this->getActiveShoppingCarts(),
            'averageSaleValueLastMonth' => round($this->getAverageSaleValueLastMonth(), 2),
            'averageSaleValue' => round($this->getAverageSaleValue(), 2),
            'top5' => $this->getTop5SoldProductsLast30Days()[0],
            'top5prices' => $this->getTop5SoldProductsLast30Days()[1],
            'top5quantities' => $this->getTop5SoldProductsLast30Days()[2],
            'allProducts' => Product::all()
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

    public function adminOrders(): View
    {
        verifyAdmin();

        $orders = Purchase::all()->sortByDesc('timestamp');

        return view('pages.adminOrders', [
            'orders' => $orders
        ]);
    }

    public function adminProducts(): View
    {
        verifyAdmin();
        return view('pages.adminProductsManage', [
            'products' => Product::orderBy('id')->get(),
            'discountFunction' => function ($price, $discount) {
                return $price * (1 - $discount);
            }
        ]);
    }

    public function adminProductsAdd(): View
    {
        verifyAdmin();
        return view('pages.adminProductsAdd');
    }

    public function adminProductsHighlights(): View
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

    public function adminProductsManage(): View
    {
        verifyAdmin();
        return view('pages.adminProductsManage', [
            'products' => Product::where('deleted', '=', false)->orderBy('id')->get(),
            'discountFunction' => function ($price, $discount) {
                return $price * (1 - $discount);
            }
        ]);
    }

    public function adminProfile(): View
    {
        verifyAdmin();
        $admin = Admin::findOrFail(Auth::guard('admin')->id());

        return view('pages.adminProfile', [
            'admin' => $admin
        ]);
    }

    public function editProfileForm(): View
    {
        verifyAdmin();
        $admin = Admin::findOrFail(Auth::guard('admin')->id());

        return view('pages.editAdmin', [
            'admin' => $admin
        ]);
    }

    public function editProfile(Request $request)
    {
        verifyAdmin();
        $admin = Admin::findOrFail(Auth::guard('admin')->id());

        if ($request->password !== $request->password_confirmation)
            return back()->withErrors(['password' => 'As passwords introduzidas não coincidem']);

        if (!Hash::check($request->password, $admin->password))
            return back()->withErrors(['password' => 'A password introduzida não corresponde à sua password atual']);

        $request->validate([
            'nome' => 'required|string|max:256',
            'email' => 'required|email|max:256',
        ]);

        if ($request->email != $admin->email) {
            if (Admin::where('email', '=', $request->email)->first())
                return back()->withErrors(['email' => 'O endereço de e-mail introduzido já pertence a um outro administrador.']);
        }

        $query = User::where('email', '=', $request->email)->first();
        if ($query) {
            if (!($query->became_admin))
                return back()->withErrors(['email' => 'O endereço de e-mail introduzido já pertence a um utilizador.']);
        }

        if ($request->file && !($request->deletePhoto)) {
            $oldPhoto = $admin->profile_image;
            $fileController = new FileController();
            $hash = $fileController->upload($request, 'admin_profile', $admin->id);
            $admin->update(array('profile_image' => $hash));
            if ($oldPhoto)
                FileController::delete($oldPhoto);
        } else if ($request->deletePhoto) {
            FileController::delete($admin->profile_image);
            $admin->update(array('profile_image' => null));
        }

        $admin->update(array('nome' => $request->nome, 'email' => $request->email));

        return redirect('/adminProfile');
    }

    public function editPasswordForm(Request $request): View
    {
        verifyAdmin();
        $admin = Admin::findOrFail(Auth::guard('admin')->id());

        return view('pages.editAdminPassword', [
            'admin' => $admin,
        ]);
    }

    public function editPassword(Request $request)
    {
        verifyAdmin();
        $admin = Admin::findOrFail(Auth::guard('admin')->id());

        if (!Hash::check($request->old_password, $admin->password))
            return back()->withErrors(['old_password' => 'A sua password atual está incorreta']);

        if ($request->new_password !== $request->new_password_confirmation)
            return back()->withErrors(['password_confirmation' => 'As passwords introduzidas não coincidem']);

        if (strlen($request->new_password) < 8)
            return back()->withErrors(['new_password' => 'A nova password deve ter, pelo menos, 8 caracteres.']);

        $admin->update(array('password' => Hash::make($request->new_password)));

        return redirect('/adminProfile');
    }

    public function adminShipping(): View
    {
        verifyAdmin();
        return view('pages.adminShipping');
    }

    public function adminUsers(): View
    {
        verifyAdmin();
        return view('pages.adminUsers', [
            'users' => User::where('deleted', '=', false)->orderBy('id')->get(),
        ]);
    }

    public function adminFAQ(): View
    {
        verifyAdmin();
        return view('pages.adminFAQ', [
            'faqs' => Faqs::all()
        ]);
    }

    public function adminPromoCode(): View
    {
        verifyAdmin();
        return view('pages.adminPromoCode', [
            'promoCodes' => PromoCode::all()
        ]);
    }

    public function adminPromoCodeAdd(): View
    {
        verifyAdmin();
        return view('pages.adminPromoCodeAdd');
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

    public function getActiveShoppingCarts()
    {

        return ProductCart::select('id_utilizador')->where('timestamp', '>', now()->subDays(30))->groupBy('id_utilizador')->get()->count();

    }

    public function getAverageSaleValueLastMonth()
    {

        $purchases = Purchase::where('timestamp', '>', now()->subDays(30))->get();

        $total = 0;

        foreach ($purchases as $purchase) {
            $total += $purchase->total;
        }

        return $total / $purchases->count();
    }

    public function getAverageSaleValue()
    {

        $purchases = Purchase::all();

        $total = 0;

        foreach ($purchases as $purchase) {
            $total += $purchase->total;
        }

        return $total / $purchases->count();
    }

    public function getTop5SoldProductsLast30Days()
    {


        $top5products =
            DB::select("SELECT produto.id, produto.nome as nome, SUM(produtoCompra.preco) as totalPreco, produto.product_image, produto.categoria, SUM(produtoCompra.quantidade) as totalQuantidade
            FROM produtoCompra
            JOIN produto ON produto.id = produtoCompra.id_produto
            JOIN compra ON compra.id = produtoCompra.id_compra
            GROUP BY produto.id
            ORDER BY totalQuantidade DESC
            LIMIT 5
            ");

        /*
                    $top5products = ProductPurchase::select(
                        'produto.id',
                        'produto.nome as nome',
                        DB::raw('SUM(produtoCompra.preco) as totalPreco'),
                        'produto.product_image',
                        'produto.categoria',
                        DB::raw('SUM(produtoCompra.quantidade) as totalQuantidade')
                    )
                    ->join('produto', 'produto.id', '=', 'produtoCompra.id_produto')
                    ->join('compra', 'compra.id', '=', 'produtoCompra.id_compra')
                    ->where('compra.timestamp', '>', now()->subDays(30))
                    ->groupBy('produto.id')
                    ->orderByDesc('totalQuantidade')
                    ->limit(5)
                    ->get();
        */


        $top5prices = [];
        foreach ($top5products as $product) {
            $purchases = ProductPurchase::where('id_produto', '=', $product->id)->get();
            $total = 0;
            foreach ($purchases as $purchase)
                $total += $purchase->preco * $purchase->quantidade;
            array_push($top5prices, $total);
        }

        $top5Quantities = []; foreach ($top5products as $product) {
            $purchases = ProductPurchase::where('id_produto', '=', $product->id)->get();
            $total = 0;
            foreach ($purchases as $purchase)
                $total += $purchase->quantidade;
            array_push($top5Quantities, $total);
        }


        return [$top5products, $top5prices, $top5Quantities];
    }


    public function getProductById($id)
    {
        return Product::find($id);
    }

    // I will create a function for a search bar in the admin page to search for products id that returns the view with the product
    public function searchProductById(Request $request)
    {
        $idString = $request->id;

        $idString = ltrim($idString, '0' );


        // Attempt to convert the string to an integer
        $id = intval($idString, 10);

        // Check if the conversion was successful
        if ($id == 0 && $idString !== '0') {
            return redirect('/adminProductsManage')->withErrors(['id' => 'O ID introduzido não é válido.']);
        }

        $product = Product::find($id);

        if (!$product) {

            return redirect('/adminProductsManage')->withErrors(['id' => 'O ID do Produto não existe.']);
        }

        return redirect('/products/' . $product->id);
    }

}
