<?php

namespace App\Http\Resources\Expenses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillablePaymentResource extends JsonResource
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
            'amount' => $this->amount,
            'person' => [
                'id' => $this->expensePeople->id,
                'name' => $this->expensePeople->name,
            ],
        ];
    }
}
