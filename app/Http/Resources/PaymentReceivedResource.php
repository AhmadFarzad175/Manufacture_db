<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentReceivedResource extends JsonResource
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
            'date' => $this->date,
            'party' => [
                'id' => $this->party->id,
                'name' => $this->party->name,
            ],
            'addedBy' => [
                'id' => $this->user_id,
                'name' => $this->user->name,
            ],
            'amount' => $this->amount,
            'reference' => $this->reference,
        ];
    }
}
