<?php

namespace App\Http\Resources\Purchases;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
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
            'invoiceNumber' => $this->invoice_number,
            'supplier' => [
                'id' => $this->supplier->id,
                'name' => $this->supplier->name,
                'email' => $this->supplier->email,
                'phone' => $this->supplier->phone,
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
                'name' => $this->currency?->name ?? null,
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
            // 'purchaseDetails' => $this->materials,
            'purchaseDetails' => PurchaseDetailResource::collection($this->materials),

        ];
    }
}
