<?php

namespace App\Http\Resources\Sales;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleExpenseResource extends JsonResource
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
            'reference' => $this->reference,
            'amount' => $this->amount,
            'details' => $this->details,
            'category' => [
                'id' => $this->expense_category_id,
                'name' => $this->expenseCategory->name,
            ],
            'account' => [
                'id' => $this->account_id,
                'name' => $this->account->name,
            ],
            'addedBy' => [
                'id' => $this->user_id,
                'name' => $this->user->name,
            ],
        ];
    }
}
