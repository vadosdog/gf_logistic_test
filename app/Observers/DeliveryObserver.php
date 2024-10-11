<?php

namespace App\Observers;

use App\Models\Delivery;
use App\Events\DeliveryDelivered;
class DeliveryObserver
{
    /**
     * Handle the Delivery "created" event.
     */
    public function created(Delivery $delivery): void
    {
        //
    }

    /**
     * Handle the Delivery "updated" event.
     */
    public function updated(Delivery $delivery): void
    {
        // Если статус изменен на "delivered", вызываем событие
        if ($delivery->wasChanged('status') && $delivery->status === Delivery::STATUS_DELIVERED) {
            event(new DeliveryDelivered($delivery));
        }
    }

    /**
     * Handle the Delivery "deleted" event.
     */
    public function deleted(Delivery $delivery): void
    {
        //
    }

    /**
     * Handle the Delivery "restored" event.
     */
    public function restored(Delivery $delivery): void
    {
        //
    }

    /**
     * Handle the Delivery "force deleted" event.
     */
    public function forceDeleted(Delivery $delivery): void
    {
        //
    }


}
