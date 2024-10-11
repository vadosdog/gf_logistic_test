<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends JsonResource
{
    protected $errorMessage = null;

    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'id' => $this->id,
            'status' => $this->status,
        ];
    }

    public static function errorResponse(string $message): array
    {
        return [
            'success' => false,
            'message' => $message,
            'data' => null,
        ];
    }
}