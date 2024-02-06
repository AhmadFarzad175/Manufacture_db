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
        $paid = $this->paymentSents()->sum('sent_amount');
        $receivable = $this->paymentReceiveds()->sum('received_amount');

        $spend = $paid - $receivable;
        $payable = ''; // You need to define how to get payable data

        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'paid' => $paid,
            'spend' => $spend,
            'receivable' => $receivable,
            // 'payable' => $payable,
        ];
    }
}
