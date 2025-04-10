<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            "order_number" => $this->order_no,
            "total" => $this->total,
            "status" => $this->status,
            "payment_details" => new PaymentResource($this->whenLoaded('payment')),
            "order_items" => OrderProductResource::collection($this->orderProducts),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
