<?php

namespace App\Http\Requests\Sales;

use App\Traits\UpdateRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
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
            'account_id' => $this->input('accountId'),
            'warehouse_id' => $this->input('warehouseId'),
            'customer_id' => $this->input('customerId'),
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
            'invoice_number' => 'required',
            'warehouse_id' => 'required|exists:warehouses,id',
            'user_id' => 'required|exists:users,id',
            'customer_id' => 'required|exists:suppliers,id',
            'paid' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:received,pending,ordered',
            'shipping' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'currency_id' => 'required|exists:currencies,id',
            'account_id' => 'required|exists:accounts,id',
            'note' => 'nullable',
            'materialDetails.*.productId' => 'required|exists:products,id',
            'materialDetails.*.quantity' => 'required|integer|min:1',
            'materialDetails.*.unitCost' => 'required|numeric|min:0',
        ];

        $this->isMethod('PUT') ? $this->applyUpdateRules($rules) : null;

        return $rules;
    }
}
