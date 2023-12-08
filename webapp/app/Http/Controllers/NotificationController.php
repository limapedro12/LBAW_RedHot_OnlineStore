<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

/*
Route::controller(NotificationController::class)->group(function () {
    Route::get('/notifications', 'listNotifications')->name('notifications');
    Route::get('/notifications/{id}', 'notificationDetails')->name('notificationDetails');
    Route::post('/notifications/{id}/delete', 'deleteNotification')->name('deleteNotification');
    Route::post('/notifications/{id}/mark_as_read', 'markNotificationAsRead')->name('markNotificationAsRead');
    
    Route::get('/adminNotifications', 'adminNotifications')->name('adminNotifications');
    Route::get('/adminNotifications/{id}', 'notificationDetails')->name('adminNotificationDetails');
    Route::post('/adminNotifications/{id}/delete', 'deleteNotification')->name('deleteAdminNotification');
    Route::post('/adminNotifications/{id}/mark_as_read', 'markNotificationAsRead')->name('markAdminNotificationAsRead');
});
*/

class NotificationController extends Controller {
    public function listNotifications(int $user_id) {
        $notifications = Notification::where('id_utilizador', '=', $user_id)->orderBy('timestamp', 'desc')->get();
        return view('pages.notifications', ['notifications' => $notifications]);
    }

    public function notificationDetails(int $id) {
        $notification = Notification::findOrFail($id);
        return view('pages.notificationDetails', ['notification' => $notification]);
    }

    public function deleteNotification(int $id) {
        Product::findOrFail($id)->delete();
        return redirect()->route('notifications');
    }

    public function markNotificationAsRead(int $id) {
        return redirect()->route('notifications');
    }
}
