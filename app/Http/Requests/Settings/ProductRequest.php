<?php

namespace App\Http\Requests\Settings;

use App\Traits\UpdateRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{

    use UpdateRequestRules;
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
    public function rules()
    {
        $rules = [
            'code' => 'required|integer',
            'name' => 'required|string',
            'image' => 'nullable|string|image',
            'material_category_id' => 'required|exists:material_categories,id',
            'unit_id' => 'required|exists:units,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|numeric|min:0',
            'stock_alert' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ];


        // CHECKING FOR THE UPDATE METHOD
        $this->isMethod('PUT') ? $this->applyUpdateRules($rules) : null;

        return $rules;
    }
}
