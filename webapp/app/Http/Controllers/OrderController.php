<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Admin;
use App\Models\Order;


class OrderController extends Controller
{
    public function showProfileDetails(int $id): View
    {
        $user = User::findOrFail($id);

        verifyUser($user);

        $orders = Order::where('id_utilizador', $id)->get();

        return view('pages.user', [
            'user' => $user,
            'totalOrders' => $this->getTotalOrders($id),
            'totalReviews' => $this->getTotalReviews($id),
            'orders' => $orders,
            'unreadNotifications' => $this->getNumberOfUreadNotifications($id)
        ]);
    }

    public function getNormalizeOrderId(int $id)
    {

        $highestId = Order::max('id');
        $highestIdLength = strlen((string) $highestId);
        $id = (string) $id;
        $idLength = strlen((string) $id);
        $id = str_pad($id, $highestIdLength + 1 - $idLength, '0', STR_PAD_LEFT);
        return $id;

    }
}
