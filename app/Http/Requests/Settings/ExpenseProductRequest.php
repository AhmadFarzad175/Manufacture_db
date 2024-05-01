<?php

namespace App\Http\Requests\Settings;

use App\Traits\UpdateRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class ExpenseProductRequest extends FormRequest
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
            'unit_id' => $this->input('unitId'),
            'stock_alert' => $this->input('stockAlert'),

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
            'code' => 'required|string',
            'name' => 'required|string',
            'image' => 'nullable|image',
            'expense_category_id' => 'required',
            'unit_id' => 'required',
            'price' => 'required|min:0',
            'stock' => 'nullable|min:0',
            'stock_alert' => 'required|min:0',
            'details' => 'nullable|string',
        ];


        $this->isMethod('PUT') ? $this->applyUpdateRules($rules) : null;

        return $rules;
    }
}
