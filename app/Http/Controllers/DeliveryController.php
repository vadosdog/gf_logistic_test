<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeStatusRequest;
use App\Services\Delivery\ChangeStatusInterface;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Response;

class DeliveryController extends Controller
{
    /**
     * @param ChangeStatusRequest $request
     * @param ChangeStatusInterface $service
     * @return ResponseFactory|Application|\Illuminate\Http\Response
     */
    public function statusChange(ChangeStatusRequest $request, ChangeStatusInterface $service): ResponseFactory|Application|\Illuminate\Http\Response
    {
        try {
            $service->changeStatus($request->deliveryId(), $request->getStatus());
        } catch (ModelNotFoundException$e) {
            return response($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return response('', Response::HTTP_OK);
    }
}
