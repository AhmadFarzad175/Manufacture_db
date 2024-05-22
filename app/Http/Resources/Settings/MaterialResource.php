<?php

namespace App\Http\Resources\Settings;

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
       
        $imageUrl = asset('storage/' . $this->image);
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'image' => $imageUrl,
            'cost' => $this->cost,
            'stock' => $this->stock,
            'stockAlert' => $this->stock_alert,
            'details' => $this->details,
          
            'materialCategory' => [
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
