<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->resource->name,
            'price' => $this->resource->price,
            'category' => $this->whenLoaded('category', function () {
                return $this->resource->category->name;
            }),
        ];
    }
}
