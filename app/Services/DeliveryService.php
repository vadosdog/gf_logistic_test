<?php

namespace App\Services;

use App\Models\Delivery;

class DeliveryService
{
    /**
     * Изменение статуса доставки.
     *
     * @param  Delivery  $delivery
     * @param  string  $newStatus
     * @return Delivery|array
     */
    public function changeStatus(Delivery $delivery, string $newStatus): Delivery|array
    {
        // Проверка возможности смены статуса
        if (!$delivery->canUpdateStatus($newStatus)) {
            return [
                'success' => false,
                'message' => 'неверный статус для смены',
                'data' => null,
            ];
        }

        // Обновление статуса
        $delivery->status = $newStatus;
        $delivery->save();

        return $delivery;
    }
}