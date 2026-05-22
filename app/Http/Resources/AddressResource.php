<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'city'       => $this->city,
            'street'     => $this->street,
            'house'      => $this->house,
            'apartment'  => $this->apartment,
            'comment'    => $this->comment,
            'is_default' => (bool) $this->is_default,
        ];
    }
}

