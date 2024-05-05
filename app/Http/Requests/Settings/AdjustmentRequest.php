<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class AdjustmentRequest extends FormRequest
{


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
        return [
            'date' => 'required|date',
            'warehouse_id' => 'required|exists:warehouses,id',
            'details' => 'nullable|string',
            'adjustmentDetails.*.productMaterialId' => 'required|integer',
            'adjustmentDetails.*.type' => 'required|integer',
            'adjustmentDetails.*.kind' => 'required|integer',
            'adjustmentDetails.*.amount' => 'required|numeric|min:0',
        ];
    }
}
