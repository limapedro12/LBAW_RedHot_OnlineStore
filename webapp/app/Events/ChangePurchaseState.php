<?php

namespace App\Events;

use App\Models\Notification;
use App\Models\Purchase;

class ChangePurchaseState extends NotificationEvent
{
    public int $purchaseId;
    public string $newState;

    // Here you create the message to be sent when the event is triggered.
    public function __construct(int $purchaseId, int $userId, string $newState)
    {
        $this->purchaseId = $purchaseId;
        $this->newState = $newState;


        $order = Purchase::find($purchaseId);

        $order = $order->getNormalizeOrderId($purchaseId);



        $message = 'A sua compra REF ' . $order . ' mudou para o estado "' . $newState . '"';
        $link = '/users/' . $userId . '/orders/' . $purchaseId;

        $this->createUserNotification($userId, $message, $link);
    }
}
