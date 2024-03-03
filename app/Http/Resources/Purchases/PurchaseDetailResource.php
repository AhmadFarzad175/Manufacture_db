<?php

namespace App\Http\Resources\Purchases;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'purchase_id' => $this->purchase_id,
            'material_id' => $this->material_id,
            'quantity' => $this->quantity,
            'unit_cost' => $this->unit_cost,
        ];
    }
}
