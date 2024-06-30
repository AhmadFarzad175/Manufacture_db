<?php

namespace App\Http\Resources\Finances;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnerPaymentReceivedResource extends JsonResource
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
            'reference' => $this->reference,
            'date' => $this->date,
            'amount' => $this->amount,
            'details' => $this->details,
            'account' => [
                'id' => $this->account->id,
                'name' => $this->account->name,
            ],
            'addedBy' => [
                'id' => $this->user_id,
                'name' => $this->user->name,
            ],
            'owner' => [
                'id' => $this->owner_id,
                'name' => $this->owner->name,
            ]
        ];
    }
}
