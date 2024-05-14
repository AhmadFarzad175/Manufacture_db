<?php

namespace App\Http\Resources\Settings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $imageUrl = asset('storage/' . $this->image);

        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'image' => $imageUrl,
            'price' => $this->price,
            'amount' => $this->amount,
            'stockAlert' => $this->stock_alert,
            'materialCategory' => [
                'id' => $this->expenseCategory->id,
                'name' => $this->expenseCategory->name
            ],
            'unit' => [
                'id' => $this->unit->id,
                'name' => $this->unit->name
            ],

        ];    }
}
