<?php

namespace App\Services\Delivery;

interface ChangeStatusInterface
{
    public function changeStatus(int $id, string $status): void;
}
