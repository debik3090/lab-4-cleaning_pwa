<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'slug'         => $this->slug,
            'short_text'   => $this->short_text,
            'full_text'    => $this->full_text,
            'image_url'    => $this->image_url,
            'published_at' => optional($this->published_at)->toIso8601String(),
            'is_published' => (bool) $this->is_published,
        ];
    }
}

