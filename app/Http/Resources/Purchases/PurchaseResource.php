<?php

namespace App\Http\Resources\Purchases;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'reference' => $this->reference,
            'addedBy' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'grandTotal' => $this->total,
            'paid' => $this->paid,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'status' => $this->status,
            'shipping' => $this->shipping,
            'note' => $this->note,
            'supplier' => [
                'id' => $this->supplier->id,
                'name' => $this->supplier->name,
            ],
            'purchaseDetails' => $this->materials,
        ];
    }
}
