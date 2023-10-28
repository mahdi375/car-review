<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'star' => $this->star,
            'review' => $this->review,
            'user' => UserResource::make($this->whenLoaded('user')),
            'car' => UserResource::make($this->whenLoaded('car')),
            'created_at' => $this->created_at,
        ];
    }
}
