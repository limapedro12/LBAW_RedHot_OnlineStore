<?php

namespace App\Events;

use App\Models\Notification;

class CancelOrder extends NotificationEvent {

    // Here you create the message to be sent when the event is triggered.
    public function __construct(int $orderId, string $userName, string $userId) {
        $message = 'A encomenda ' . $orderId . ' do utilizador ' . $userName . ' foi cancelada pelo utilizador.';
        $link = '/users/' . $userId . '/orders/' . $orderId;

        $this->createNotificationToAllAdmins($message, $link);
    }

    public function broadcastAs() {
        return 'notification-to-all-admins';
    }
}
