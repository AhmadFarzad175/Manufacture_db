<?php

namespace App\Http\Resources\Settings;

use App\Models\Settings\TransferDetails;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
{
    $items = $this->transferDetails->sum('quantity');

    return [
        'id' => $this->id,
        'date' => $this->date,
        'references' => $this->reference,
        'total' => $this->total,
        'status' => $this->status,
        'fromWarehouse' => [
            'id' => $this->from_warehouse_id,
            'name' => $this->fromWarehouse->name,
        ],
        'toWarehouse' => [
            'id' => $this->to_warehouse_id,
            'name' => $this->toWarehouse->name,
        ],
        'items' => $items,
    ];
}
}
