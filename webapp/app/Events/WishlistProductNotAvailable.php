<?php

namespace App\Events;

use App\Models\Notification;

class WishlistProductNotAvailable extends NotificationEvent
{

    public function __construct(int $userId, int $productId, string $productName)
    {
        $message = 'O preço do produto ' . $productName . ', que está na sua wishlist, já não está disponível';
        $link = '/products/' . $productId;

        $this->createUserNotification($userId, $message, $link);
    }
}
