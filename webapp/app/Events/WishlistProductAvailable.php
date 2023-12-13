<?php

namespace App\Events;

use App\Models\Notification;

class WishlistProductAvailable extends NotificationEvent {
    // Here you create the message to be sent when the event is triggered.
    public function __construct(int $userId, int $productId, string $productName) {
        $message = 'O preço do produto '.$productName.', que está na sua wishlist, já está disponível';
        $link = '/products/'.$productId;

        $this->createUserNotification($userId, $message, $link);
    }
}
