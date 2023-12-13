<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Notification;

abstract class NotificationEvent implements ShouldBroadcast{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $notificationId;
    public string $message;
    public string $timestamp;
    public int $userId = 0;
    public int $adminId = 0;
    public string $linkToRedirect = '';
    public bool $lida;
    public string $channel;

    public function broadcastOn() {
        return 'RedHot';
    }

    public function broadcastAs(){
        return $this->channel;
    }

    protected function createUserNotification(int $userId, string $message, string $linkToRedirect) {
        $this->userId = $userId;
        $this->timestamp = now();
        $this->message = $message;
        $this->lida = false;
        $this->linkToRedirect = $linkToRedirect;
        
        $notification = Notification::create(['texto' => $this->message, 
                                              'timestamp' => now(), 
                                              'id_utilizador' => $userId, 
                                              'link' => $linkToRedirect]);
        $this->notificationId = $notification->id;
        $this->channel = 'notification-to-user-' . $this->userId;
    }

    protected function createAdminNotification(int $adminId, string $message, string $linkToRedirect) {
        $this->adminId = $adminId;
        $this->timestamp = now();
        $this->message = $message;
        $this->lida = false;
        $this->linkToRedirect = $linkToRedirect;
        
        $notification = Notification::create(['texto' => $this->message, 
                                              'timestamp' => now(), 
                                              'id_administrador' => $adminId, 
                                              'link' => $linkToRedirect]);
        $this->notificationId = $notification->id;
        $this->channel = 'notification-to-admin-' . $this->adminId;
    }

    protected function createNotificationToAllAdmins(string $message, string $linkToRedirect) {
        $this->timestamp = now();
        $this->message = $message;
        $this->lida = false;
        $this->linkToRedirect = $linkToRedirect;
        
        $notification = Notification::create(['texto' => $this->message, 
                                              'timestamp' => now(), 
                                              'link' => $linkToRedirect,
                                              'para_todos_administradores' => true]);
        $this->notificationId = $notification->id;
        $this->channel = 'notification-to-all-admins';
    }
}
