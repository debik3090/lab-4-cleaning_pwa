<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'service'  => new ServiceResource($this->whenLoaded('service')),
            'quantity' => $this->quantity,
            'price'    => (float) $this->price,
            'subtotal' => (float) $this->subtotal,
        ];
    }
}

