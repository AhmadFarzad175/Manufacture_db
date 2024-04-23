<?php

namespace App\Http\Requests\Purchases;

use App\Traits\UpdateRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class SalePaymentRequest extends FormRequest
{
    use UpdateRequestRules;

    public function prepareForValidation()
    {
        return $this->merge([
            'sale_id' => $this->input('saleId'),
            'user_id' => $this->input('addedById'),
            'account_id' => $this->input('accountId'),

        ]);
    }


    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
            'reference' => 'required|string|max:192',
            'user_id' => 'required|exists:users,id',
            'sale_id' => 'required|exists:purchases,id',
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0',
            'details' => 'nullable|string',
        ];

        $this->isMethod('PUT') ? $this->applyUpdateRules($rules) : null;

        return $rules;
    }
}
