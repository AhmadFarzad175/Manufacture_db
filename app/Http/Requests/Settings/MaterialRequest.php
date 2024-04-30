<?php

namespace App\Http\Requests\Settings;

use App\Traits\UpdateRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
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
            'material_category_id' => $this->input('materialCategory'),
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
        $rules =  [
            'code' => 'required|string',
            'name' => 'required|string',
            'image' => 'nullable|image',
            'material_category_id' => 'required',
            'unit_id' => 'required',
            'cost' => 'required|min:0',
            'stock' => 'integer|min:0',
            'stock_alert' => 'nullable|min:0',
            'details' => 'nullable|string',
        ];

        $this->isMethod('PUT') ? $this->applyUpdateRules($rules) : null;

        return $rules;
    }
}
