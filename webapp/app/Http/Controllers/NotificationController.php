<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use App\Policies\UserPolicy;

function verifyUserId(int $userId) : void {
    if((Auth::user()==null || Auth::user()->id != $userId) && Auth::guard('admin')->user()==null)
        abort(403);
}

function verifyAdminId(int $adminId) : void {
    if(Auth::guard('admin')->user()==null || Auth::guard('admin')->user()->id != $adminId)
        abort(403);
}

function verifyAlterNotification(int $id){
    $notification = Notification::findOrFail($id);
    if(Auth::user() != null && 
      Auth::user()->id == $notification->id_utilizador)
        return;
    else if(Auth::guard('admin')->user() != null && 
            Auth::guard('admin')->user()->id == $notification->id_administrador)
        return;
    abort(403);
}

class NotificationController extends Controller {
    public function listNotifications(int $user_id) {
        verifyUserId($user_id);
        $notifications = Notification::where('id_utilizador', '=', $user_id)->orderBy('timestamp', 'desc')->get();
        return view('pages.notifications', ['notifications' => $notifications]);
    }

    public function adminNotifications(int $admin_id) {
        verifyAdminId($admin_id);
        $notifications = Notification::where('id_administrador', '=', $admin_id)->orderBy('timestamp', 'desc')->get();
        return view('pages.notifications', ['notifications' => $notifications]);
    }

    public function deleteNotification(int $id) {
        verifyAlterNotification($id);
        Notification::findOrFail($id)->delete();
        return;
    }

    public function markNotificationAsRead(int $id) {
        verifyAlterNotification($id);
        Notification::findOrFail($id)->update(['lida' => true]);
        return;
    }
}
