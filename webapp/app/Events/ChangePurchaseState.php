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

class ChangePurchaseState implements ShouldBroadcast{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;
    public int $purchase_id;
    public int $user_id;
    public string $new_state;

    // Here you create the message to be sent when the event is triggered.
    public function __construct(int $purchase_id, int $user_id, string $new_state) {
        $this->purchase_id = $purchase_id;
        $this->user_id = $user_id;
        $this->new_state = $new_state;
        $this->message = 'A sua compra <a href="/users/'.$user_id.'/orders/'.$purchase_id.'">REF '.$purchase_id.'</a> mudou para o estado "' . $new_state.'"';
        Notification::create(['texto' => $this->message, 'timestamp' => now(), 'id_utilizador' => $user_id]);
    }

    // You should specify the name of the channel created in Pusher.
    public function broadcastOn() {
        return 'RedHot';
    }

    // You should specify the name of the generated notification.
    public function broadcastAs() {
        return 'notification-to-user-' . $this->user_id;
    }
}
