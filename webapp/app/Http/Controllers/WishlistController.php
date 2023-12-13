<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Wishlist;

class WishlistController extends Controller
{

    public function listWishlist(int $id)
    {

        $wishlist = Wishlist::where('id_utilizador', $id)->get();

        return view('pages.wishlist', [
            'wishlist' => $wishlist,
            'discountFunction' => function ($price, $discount) {
                return $price * (1 - $discount);
            }]);
    }

    public function addToWishlist($id, $id_product)
    {

        $wishlistProduct = new Wishlist();

        $wishlistProduct->id_utilizador = $id;
        $wishlistProduct->id_produto = $id_product;

        $wishlistProduct->save();

        return redirect()->back();

    }

    public function removeFromWishlist($id, $id_product)
    {

        $wishlistProduct = Wishlist::where('id_utilizador', $id)->where('id_produto', $id_product)->first();

        $wishlistProduct->delete();

        return redirect()->back();
    }
}
