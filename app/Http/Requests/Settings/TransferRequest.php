<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
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
            'reference' => 'required|unique:transfers,reference',
            'from_warehouse_id' => 'required|exists:warehouses,id',
            'to_warehouse_id' => 'required|exists:warehouses,id',
            'total' => 'required|numeric|min:0',
            'status' => 'required|integer',
            'shipping' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'details' => 'nullable|string',
            'transferDetails.*.transferId' => 'required|exists:transfers,id',
            'transferDetails.*.productMaterial_id' => 'required|integer',
            'transferDetails.*.type' => 'required|numeric|min:0',
        ];
    }
}
