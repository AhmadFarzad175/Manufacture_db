<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    // public function prepareForValidation()
    // {
    //     $dataToMerge = [];

    //     // List of fields that can be updated
    //     $updateableFields = ['expenseCategoryId', 'partyId', 'branchId', 'AddedById'];

    //     foreach ($updateableFields as $field) {
    //         if ($this->has($field)) {
    //             $dataToMerge[Str::snake($field)] = $this->input($field);
    //         }
    //     }

    //     $this->merge($dataToMerge);
    // }

    public function prepareForValidation()
    {
        $dataToMerge = [];

        // List of fields that can be updated
        $updateableFields = ['expenseCategoryId', 'partyId', 'branchId', 'AddedById'];

        foreach ($updateableFields as $field) {
            if ($this->has($field)) {
                // If $field is 'AddedById', set 'user_id' in $dataToMerge
                $dataToMerge[$field === 'AddedById' ? 'user_id' : Str::snake($field)] = $this->input($field);
            }
        }

        $this->merge($dataToMerge);
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
            'amount' => 'required|integer', // Add any other rules for the 'amount' field
            'party_id' => 'required|exists:parties,id', // Add any other rules for the 'receiver_id' field
            'user_id' => 'required|integer', // Add any other rules for the 'added_by' field
            'branch_id' => 'required|exists:branches,id',
            'details' => 'nullable|string',
        ];

        // CHECKING FOR THE UPDATE METHOD
        if ($this->isMethod('PUT')) {

            // Convert 'required' to 'sometimes' for all rules
            foreach ($rules as $key => $rule) {
                $rules[$key] = str_replace('required', 'sometimes', $rule);
            }
        }

        return $rules;
    }
}
