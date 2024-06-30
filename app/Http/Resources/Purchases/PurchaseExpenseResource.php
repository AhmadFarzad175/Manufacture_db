<?php

namespace App\Http\Resources\Purchases;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseExpenseResource extends JsonResource
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
            'purchase_id' => $this->purchase_id,
            'date' => $this->date,
            'reference' => $this->reference,
            'amount' => $this->amount,
            'details' => $this->details,
            'addedBy' => [
                'id' => $this->user_id,
                'name' => $this->user->name,
            ],
        ];
    }
}
