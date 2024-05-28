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
        $this->merge([
            'user_id' => $this->input('addedById'),
            'warehouse_id' => $this->input('warehouseId'),
            'supplier_id' => $this->input('supplierId'),
            'currency_id' => $this->input('currencyId'),
            'invoice_number' => $this->input('invoiceNumber'),
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
            'invoice_number' => 'required|integer',
            'warehouse_id' => 'required',
            'supplier_id' => 'required',
            'paid' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'status' => 'required',
            'shipping' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0', 
            'tax' => 'nullable|numeric|min:0',
            'currency_id' => 'nullable',
            'note' => 'nullable',
            'materialDetails.*.id' => 'required',
            'materialDetails.*.purchase_id' => 'required',
            'materialDetails.*.quantity' => 'required|integer|min:1',
            'materialDetails.*.unitCost' => 'required|numeric|min:0',
        ];

        $this->isMethod('PUT') ? $this->applyUpdateRules($rules) : null;

        return $rules;
    }
}
