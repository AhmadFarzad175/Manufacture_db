<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaterialRequest extends FormRequest
{
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
            'material_category_id' => $this->input('materialCategoryId'),
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
        return [
            'code' => 'sometimes|string',
            'name' => 'sometimes|string',
            'image' => 'nullable',
            'material_category_id' => 'sometimes',
            'unit_id' => 'sometimes',
            'cost' => 'sometimes|min:0',
            'stock' => 'nullable|min:0',
            'stock_alert' => 'nullable|min:0',
            'description' => 'nullable|string',
        ];
    }
}
