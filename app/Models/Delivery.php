<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель доставки
 *
 * @property int $id
 * @property string $status
 */
class Delivery extends Model
{
    use HasFactory;

    const STATUS_PLANNED = 'planned';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';

    protected $fillable = ['status'];


    // Проверяет, можно ли сменить статус на следующий

    public function canUpdateStatus(string $newStatus): bool
    {
        $statuses = [
            self::STATUS_PLANNED,
            self::STATUS_SHIPPED,
            self::STATUS_DELIVERED,
        ];

        $currentIndex = array_search($this->status, $statuses);
        $newIndex = array_search($newStatus, $statuses);

        return $newIndex !== false && $newIndex === $currentIndex + 1;
    }
}
