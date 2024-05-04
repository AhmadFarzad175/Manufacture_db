<?php

namespace App\Http\Resources\Settings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdjustmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $items = $this->adjustmentDetails->sum('amount');

        return [
            'id' => $this->id,
            'date' => $this->date,
            'references' => $this->reference,
            'Warehouse' => [
                'id' => $this->warehouse_id,
                'name' => $this->warehouse->name,
            ],
            'totalProdcuts' => $items,
            'adjustmentDetails' => $this->adjustmentDetails
        ];
    }
}
