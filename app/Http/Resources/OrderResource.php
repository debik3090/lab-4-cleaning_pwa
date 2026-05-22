<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'status'         => $this->status,
            'total_price'    => (float) $this->total_price,
            'payment_status' => $this->payment_status,
            'comment'        => $this->comment,
            'items'          => OrderItemResource::collection(
                $this->whenLoaded('items')
            ),
        ];
    }
}

