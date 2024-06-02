<?php

namespace App\Http\Requests\Purchases;

use App\Traits\UpdateRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class PurchaseExpenseRequest extends FormRequest
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
        return $this->merge([
            'expense_category_id' => $this->input('expenseCategory'),
            'account_id' => $this->input('account'),
            'purchase_id' => $this->input('purchaseId'),

        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'date' => 'required|date',
            'purchase_id' => 'required',
            'expense_category_id' => 'required',
            'account_id' => 'required',
            'amount' => 'required|numeric|min:0',
            'details' => 'nullable|string',
        ];

        $this->isMethod('PUT') ? $this->applyUpdateRules($rules) : null;

        return $rules;
    }
}
