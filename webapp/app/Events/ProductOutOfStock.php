<?php

namespace App\Events;

use App\Models\Notification;

class ProductOutOfStock extends NotificationEvent {

    // Here you create the message to be sent when the event is triggered.
    public function __construct(int $adminId, int $productId, string $productName) {
        $message = 'O produto '.$productName.' está sem de stock';
        $link = '/products/'.$productId;

        $this->createAdminNotification($adminId, $message, $link);
    }

    public function broadcastAs() {
        return 'notification-to-admin-' . $this->adminId;
    }
}
