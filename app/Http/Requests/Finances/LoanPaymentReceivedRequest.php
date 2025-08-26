<?php

namespace App\Http\Requests\Finances;

use App\Traits\UpdateRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class LoanPaymentReceivedRequest extends FormRequest
{
    use UpdateRequestRules;

    public function prepareForValidation()
    {
        return $this->merge([
            'loan_people_id' => $this->input('expensePeople'),
            'account_id' => $this->input('account'),

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
            'loan_people_id' => 'required|exists:expense_peoples,id',
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0',
            'details' => 'nullable|string',
        ];

        $this->isMethod('PUT') ? $this->applyUpdateRules($rules) : null;

        return $rules;
    }
}
