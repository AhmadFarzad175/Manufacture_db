<?php

namespace App\Http\Requests\Expenses;

use App\Traits\UpdateRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
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
            'expense_category_id' => $this->input('expenseCategoryId'),
            'expense_people_id' => $this->input('personId'),

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
            'expense_category_id' => 'required|exists:expense_categories,id',
            'expense_people_id' => 'required|exists:expense_peoples,id',
            'amount' => 'required',
            'details' => 'nullable|string',
        ];

        $this->isMethod('PUT') ? $this->applyUpdateRules($rules) : null;

        return $rules;
    }
}
