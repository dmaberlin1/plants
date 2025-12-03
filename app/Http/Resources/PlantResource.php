<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'age' => $this->age,
            'type' => [
                'id' => $this->type->id,
                'title' => $this->type->title,
            ],
            'protection_products' => $this->protectionProducts->map(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'pivot' => [
                        'dose' => $product->pivot->dose
                    ]
                ];
            }),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
