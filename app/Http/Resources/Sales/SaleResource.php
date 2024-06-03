<?php

namespace App\Http\Resources\Sales;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $paymentStatus = '';

        if ($this->total == $this->paid) {
            $paymentStatus = 'paid';
        } elseif ($this->paid == 0) {
            $paymentStatus = 'pending';
        } elseif ($this->paid > 0 && $this->paid < $this->total) {
            $paymentStatus = 'partial';
        }

        return [
            'id' => $this->id,
            'date' => $this->date,
            'reference' => $this->reference,
            'invoice_number' => $this->invoice_number,
            'customer' => [
                'id' => $this->customer->id,
                'name' => $this->customer->name,
                'email' => $this->customer->email,
                'phone' => $this->customer->phone,
            ],
            'addedBy' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'warehouse' => [
                'id' => $this->warehouse_id,
                'name' => $this->warehouse->name,
            ],
            'currency' => [
                'id' => $this->currency_id,
                'name' => $this->currency->name,
                'symbol' => $this->currency->symbol,
            ],
            'grandTotal' => $this->total,
            'paid' => $this->paid,
            'due' => $this->total - $this->paid,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'status' => $this->status,
            'shipping' => $this->shipping,
            'paymentStatus' => $paymentStatus,
            'details' => $this->note,
            'saleDetails' => SaleDetailResource::collection($this->products),
        ];
    }
}
