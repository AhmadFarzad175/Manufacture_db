<?php

namespace App\Http\Resources;

use App\Models\PaymentSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\JsonResource;

class PartyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $paid = ($this->paymentSents()->sum('sent_amount')) - ($this->paymentReceiveds()->sum('received_amount'));
        $spent = $this->expenses()->sum('amount');
        $receivable = $paid > $spent ? $paid - $spent : 0;
        $payable = $paid < $spent ? $spent - $paid : 0;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'paid' => $paid,
            'spent' => $spent,
            'receivable' => $receivable,
            'payable' => $payable,
        ];
    }
}
