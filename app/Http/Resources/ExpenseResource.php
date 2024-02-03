<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $amount = 20;

        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'date' => $this->date,
            'expenseCategory' => [
                'id' => $this->expenseCategory->id,
                'name' => $this->expenseCategory->name
            ],
            'amount' => $amount,
            'addedBy' => $this->user_id,
            'branch' => [
                'id' => $this->branch->id,
                'name' => $this->branch->name
            ]




        ];
    }
}
