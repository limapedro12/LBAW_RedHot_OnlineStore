<?php

namespace App\Events;

use App\Models\Notification;

class ChangeInProductsPrice extends NotificationEvent {
    public int $productId;
    public string $oldPrice;
    public string $newPrice;

    // Here you create the message to be sent when the event is triggered.
    public function __construct(int $user_id, int $productId, string $productName, string $oldPrice, string $newPrice) {
        $this->productId = $productId;
        $this->oldPrice = $oldPrice;
        $this->newPrice = $newPrice;

        $message = 'O preço do produto '.$productName.', que está no seu carrinho, mudou de '.$oldPrice.'€ para '.$newPrice.'€';
        $link = '/cart';

        $this->createUserNotification($user_id, $message, $link);
    }

    public function broadcastAs() {
        return 'notification-to-user-' . $this->user_id;
    }
}
