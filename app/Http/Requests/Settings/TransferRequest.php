<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{

    public function prepareForValidation()
    {
        return $this->merge([
            'from_warehouse_id' => $this->input('fromWarehouseId'),
            'to_warehouse_id' => $this->input('toWarehouseId'),
            

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
            'from_warehouse_id' => 'required|exists:warehouses,id',
            'to_warehouse_id' => 'required|exists:warehouses,id',
            'total' => 'required|numeric|min:0',
            'status' => 'required|integer',
            'shipping' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'details' => 'nullable|string',
            'transferDetails.*.productMaterialId' => 'required|integer',
            'transferDetails.*.type' => 'required|numeric|min:0',
            'transferDetails.*.quantity' => 'required|numeric|min:0',
            'transferDetails.*.unitCost' => 'required|numeric|min:0',
        ];
    }
}
