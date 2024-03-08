<?php

namespace App\Http\Resources\Settings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountTransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "fromAccount" => $this->from_account_id,
            "toAccount" => $this->to_account_id,
            "userId" => $this->user_id,
            "fromAmount" => $this->from_amount,
            "toAmount" => $this->to_amount,
            "date" => $this->date,
        ];
    }
}
