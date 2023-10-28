<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'model' => $this->model,
            'color' => $this->color,
            'brand' => BrandResource::make($this->whenLoaded('brand')),
            'owner' => UserResource::make($this->whenLoaded('owner')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
