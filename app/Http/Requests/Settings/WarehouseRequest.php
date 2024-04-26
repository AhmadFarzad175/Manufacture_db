<?php

namespace App\Http\Requests\Settings;

use App\Traits\UpdateRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class WarehouseRequest extends FormRequest
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
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:192',
            'phone' => 'required|string|max:15',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',

        ];

        $this->isMethod('PUT') ? $this->applyUpdateRules($rules) : null;

        return $rules;
    }
}
