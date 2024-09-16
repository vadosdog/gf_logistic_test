<?php

namespace App\Observers;

use App\Events\DeliveryDelivered;
use App\Models\Delivery;
use App\Support\Status;

class DeliveryObserver
{
    public function updated(Delivery $delivery): void
    {
        if ($delivery->status == Status::DELIVERED) {
            DeliveryDelivered::dispatch($delivery);
        }
    }

    public function creating(Delivery $delivery): void
    {
        if (!$delivery->status) {
            $delivery->status = Status::PLANNED;
        }
    }
}
