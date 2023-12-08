<?php

namespace App\Events;

use App\Models\Notification;

class ChangePurchaseState extends NotificationEvent {
    public int $purchase_id;
    public string $new_state;

    // Here you create the message to be sent when the event is triggered.
    public function __construct(int $purchase_id, int $user_id, string $new_state) {
        $this->purchase_id = $purchase_id;
        $this->new_state = $new_state;

        $message = 'A sua compra REF '.$purchase_id.' mudou para o estado "' . $new_state.'"';
        $link = '/users/'.$user_id.'/orders/'.$purchase_id;

        $this->createUserNotification($user_id, $message, $link);
    }

    public function broadcastAs() {
        return 'notification-to-user-' . $this->user_id;
    }
}
