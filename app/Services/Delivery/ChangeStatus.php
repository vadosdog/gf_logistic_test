<?php

namespace App\Services\Delivery;

use App\Exceptions\StatusNotAllowedException;
use App\Models\Delivery;
use App\Repositories\DeliveryRepository;
use App\Support\Status;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RonasIT\Support\Services\EntityService;

class ChangeStatus extends EntityService implements ChangeStatusInterface
{
    public function __construct()
    {
        $this->setRepository(DeliveryRepository::class);
    }

    /**
     * @param int $id
     * @param string $status
     * @return void
     * @throws ModelNotFoundException
     * @throws StatusNotAllowedException
     */
    public function changeStatus(int $id, string $status): void
    {
        /** @var Delivery|null $delivery */
        $delivery = $this->repository->find($id);
        if (!$delivery instanceof Delivery) {
            throw new ModelNotFoundException('Delivery not found');
        }

        if (!in_array($delivery->status, Status::previous($status))) {
            throw new StatusNotAllowedException('Status not allowed');
        }

        $this->repository->update(['id' => $id], ['status' => $status]);
    }
}
