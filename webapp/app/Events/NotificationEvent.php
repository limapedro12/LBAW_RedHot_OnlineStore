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

    public int $notification_id;
    public string $message;
    public string $timestamp;
    public int $user_id = 0;
    public int $admin_id = 0;
    public string $link_to_redirect = '';
    public bool $lida;

    public function broadcastOn() {
        return 'RedHot';
    }

    abstract public function broadcastAs();

    protected function createUserNotification(int $user_id, string $message, string $link_to_redirect) {
        $this->user_id = $user_id;
        $this->timestamp = now();
        $this->message = $message;
        $this->lida = false;
        $this->link_to_redirect = $link_to_redirect;
        
        $notification = Notification::create(['texto' => $this->message, 
                                              'timestamp' => now(), 
                                              'id_utilizador' => $user_id, 
                                              'link' => $link_to_redirect]);
        $this->notification_id = $notification->id;
    }

    protected function createAdminNotification(int $admin_id, string $message, string $link_to_redirect) {
        $this->admin_id = $admin_id;
        $this->timestamp = now();
        $this->message = $message;
        $this->lida = false;
        $this->link_to_redirect = $link_to_redirect;
        
        $notification = Notification::create(['texto' => $this->message, 
                                              'timestamp' => now(), 
                                              'id_administrador' => $admin_id, 
                                                'link' => $link_to_redirect]);
        $this->notification_id = $notification->id;
    }
}
