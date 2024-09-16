<?php

namespace App\Support;

class Status
{
    public const PLANNED = 'planned';
    public const SHIPPED = 'shipped';
    public const DELIVERED = 'delivered';
    public const CANCELLED = 'cancelled';

    /**
     * @return array
     */
    public static function statuses(): array
    {
        return [
            self::PLANNED,
            self::SHIPPED,
            self::DELIVERED,
            self::CANCELLED,
        ];
    }

    /**
     * Описываем правила валидации для каждого статуса, для которого нужна валидация
     * @param $status
     * @return array
     */
    public static function rules($status): array
    {
        return match ($status) {
            self::CANCELLED => ['reason' => ['required']],
            default => [],
        };
    }

    /**
     * Описываем возможные переходы между статусами
     * @param $status
     * @return array|string[]
     */
    public static function previous($status): array
    {
        return match ($status) {
            self::SHIPPED, self::CANCELLED => [self::PLANNED],
            self::DELIVERED => [self::SHIPPED],
            default => [],
        };
    }
}
