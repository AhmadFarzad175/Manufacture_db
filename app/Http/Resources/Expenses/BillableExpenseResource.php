<?php

namespace App\Http\Resources\Expenses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillableExpenseResource extends JsonResource
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
            'invoiceNumber' => $this->invoice_number,
            'paid' => $this->paid,
            'total' => $this->total,
            'due' => $this->due,
            'details' => $this->details,
            'expensePeople' => [
                'id' => $this->expense_people_id,
                'name' => $this->expensePeople->name
            ],
            'supplier' => [
                'id' => $this->supplier_id,
                'name' => $this->supplier->name
            ],
            'addedBy' => [
                'id' => $this->user_id,
                'name' => $this->user->name
            ],
            'expenseDetails' => $this->expenseProduct,
        ];
    }
}
