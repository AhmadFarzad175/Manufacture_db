<?php

namespace App\Http\Resources\Purchases;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $paymentStatus = '';
        $due = $this->total - $this->paid;

        if ($this->total == $this->paid) {
            $paymentStatus = 'paid';
        } elseif ($this->paid == 0) {
            $paymentStatus = 'pending';
        } elseif ($this->paid > 0 && $this->paid < $this->total) {
            $paymentStatus = 'partial';
        }

        return [
            'date' => $this->date,
            'reference' => $this->reference,
            'supplier' => [
                $this->supplier->id,
                $this->supplier->name,
            ],
            'grandTotal' => $this->total,
            'paid' => $this->paid,
            'due' => $due,
            'status' => $this->status,
            'paymentStatus' => $paymentStatus,
            'shippingStatus' => isset($this->shipments->status) ? $this->shipments->status : null,
        ];
    }
}
