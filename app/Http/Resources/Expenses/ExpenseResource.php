<?php

namespace App\Http\Resources\Expenses;

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

        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'date' => $this->date,
            'amount' => $this->amount,
            'expenseCategory' => [
                'id' => $this->expenseCategory->id,
                'name' => $this->expenseCategory->name
            ],
            'addedBy' => [
                'id' => $this->user_id,
                'name' => $this->user->name,
            ],
            'person' => [
                'id' => $this->expensePeople->id,
                'name' => $this->expensePeople->name,
            ],


        ];
    }
}
