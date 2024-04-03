<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'device_uuid' => $this->user->device_uuid,
            'device_name' => $this->user->device_name,
            'receipt_token' => $this->receipt_token,
            'price' => $this->price,
            'credit' => $this->credit,
            'order_date' => $this->created_at
        ];
    }
}
