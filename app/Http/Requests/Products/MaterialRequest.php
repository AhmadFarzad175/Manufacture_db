<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
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
        $rules = [
            'code' => 'required|integer',
            'name' => 'required|string',
            'image' => 'required|string',
            'material_category_id' => 'required|exists:material_categories,id',
            'unit_id' => 'required|exists:units,id',
            'cost' => 'required|numeric|min:0',
            'stock' => 'nullable|numeric|min:0',
            'stock_alert' => 'nullable|numeric|min:0',
            'tax_type' => 'nullable|numeric',
            'description' => 'required|string',
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
