<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
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
            'name' => $this->name,
            'image' => $this->image,
            'cost' => $this->cost,
            'stock' => $this->stock,
            'stock_alert' => $this->stock_alert,
            'material_category' => [
                'id' => $this->materialCategory->id,
                'name' => $this->materialCategory->name
            ],
            'unit' => [
                'id' => $this->unit->id,
                'name' => $this->unit->name
            ],

        ];
    }
}
