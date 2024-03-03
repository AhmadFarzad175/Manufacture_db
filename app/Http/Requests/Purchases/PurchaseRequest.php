<?php

namespace App\Http\Requests\Purchases;

use App\Traits\UpdateRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    use UpdateRequestRules;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $purchaseDetails = $this->input('purchaseDetails');

        $transformedPurchaseDetails = [];

        // Inside prepareForValidation method
        foreach ($purchaseDetails as $key => $purchaseDetail) {
            $transformedPurchaseDetails[] = [
                'material_id' => $purchaseDetail['materialId'],
                'unit_cost' => $purchaseDetail['unitCost'],
                'quantity' => $purchaseDetail['quantity'],
                // Add other fields if necessary
            ];
        }


        // Merge the transformed purchaseDetails array into the request data
        $this->merge([
            'purchaseDetails' => $transformedPurchaseDetails,
            'user_id' => $this->input('addedById'),
            'supplier_id' => $this->input('SupplierId'),
            'currency_id' => $this->input('currencyId'),
            'payment_type' => $this->input('paymentType'),
        ]);
    }




    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules =  [
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'paid' => 'nullable|numeric|min:0',
            'total' => 'nullable|numeric|min:0',
            'status' => 'required|in:received,pending,ordered',
            'shipping' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'payment_type' => 'required|string',
            'tax' => 'nullable|numeric|min:0',
            'currency_id' => 'required|exists:currencies,id',
            'note' => 'nullable',


            'materialDetails.*.material_id' => 'required|exists:materials,id',
            'materialDetails.*.purchase_id' => 'required|exists:purchases,id',
            'materialDetails.*.quantity' => 'required|integer|min:1',
            'materialDetails.*.unit_cost' => 'required|numeric|min:0',
        ];

        $this->isMethod('PUT') ? $this->applyUpdateRules($rules) : null;

        return $rules;
    }
}
