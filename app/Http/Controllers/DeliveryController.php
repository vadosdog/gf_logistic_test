<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Http\Resources\DeliveryResource;
use App\Services\DeliveryService;
use App\Http\Requests\DeliveryStatusRequest;

class DeliveryController extends Controller
{
    protected $deliveryService;

    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    public function statusChange(DeliveryStatusRequest $request, Delivery $delivery)
    {

        $validated = $request->validated();
        $newStatus = $validated['status'];

        $result = $this->deliveryService->changeStatus($delivery, $newStatus);

        if (is_array($result) && !$result['success']) {
            return response()->json(DeliveryResource::errorResponse($result['message']), 400);
        }

        return new DeliveryResource($result);
    }


}
