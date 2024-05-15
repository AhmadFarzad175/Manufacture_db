<?php

namespace App\Http\Requests\Expenses;

use App\Traits\UpdateRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class BillableExpenseRequest extends FormRequest
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
        $expenseDetails = $this->input('expenseDetails');

        $transformedExpenseDetails = [];

        // Inside prepareForValidation method
        foreach ($expenseDetails as $key => $expenseDetail) {
            $transformedExpenseDetails[] = [
                'expense_product_id' => $expenseDetail['id'],
                'quantity' => $expenseDetail['quantity'],
                'price' => $expenseDetail['price'],
            ];
        }

        $this->merge([
            'expenseDetails' => $transformedExpenseDetails,
            'expense_people_id' => $this->input('personId'),
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
        $rules = [
            'date' => 'required|date',
            'expense_people_id' => 'required|exists:expense_peoples,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_number' => 'required|integer',
            'paid' => 'required|min:0',
            'total' => 'required|min:0',
            'currency_id' => 'required|exists:currencies,id',
            'details' => 'nullable|string',

            'expenseDetails' => 'required|array',
            'expenseDetails.*.expense_product_id' => 'required|exists:expense_products,id',
            'expenseDetails.*.quantity' => 'required|integer|min:1',
            'expenseDetails.*.price' => 'required|min:0',
        ];

        $this->isMethod('PUT') ? $this->applyUpdateRules($rules) : null;

        return $rules;
    }
}
