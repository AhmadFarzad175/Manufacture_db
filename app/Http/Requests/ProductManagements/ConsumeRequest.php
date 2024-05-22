<?php

namespace App\Http\Requests\ProductManagements;

use App\Traits\UpdateRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class ConsumeRequest extends FormRequest
{
    use UpdateRequestRules;

    public function prepareForValidation()
    {
        return $this->merge([
            'warehouse_id' => $this->input('warehouseId'),

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
            'warehouse_id' => 'required',
            'details' => 'nullable|string',
            'consumeDetails.*.id' => 'required',
            'consumeDetails.*.details.quantity' => 'required',
        ];

        $this->isMethod('PUT') ? $this->applyUpdateRules($rules) : null;

        return $rules;
    }
}
