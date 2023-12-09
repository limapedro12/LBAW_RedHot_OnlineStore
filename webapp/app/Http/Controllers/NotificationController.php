<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller {
    public function listNotifications(int $user_id) {
        $notifications = Notification::where('id_utilizador', '=', $user_id)->orderBy('timestamp', 'desc')->get();
        return view('pages.notifications', ['notifications' => $notifications]);
    }

    public function adminNotifications(int $admin_id) {
        // $notifications = Notification::where(function ($query) {
        //     $query->where('id_utilizador', '=', $user_id)
        //           ->orWhere('para_todos_administradores', '=', true);
        // })->orderBy('timestamp', 'desc')->get();
        $notifications = Notification::where('id_administrador', '=', $admin_id)->orderBy('timestamp', 'desc')->get();
        return view('pages.notifications', ['notifications' => $notifications]);
    }

    public function deleteNotification(int $id) {
        Notification::findOrFail($id)->delete();
        return;
    }

    public function markNotificationAsRead(int $id) {
        Notification::findOrFail($id)->update(['lida' => true]);
        return;
    }
}
