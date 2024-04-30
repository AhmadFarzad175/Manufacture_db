<?php

namespace App\Http\Requests\Settings;

use App\Traits\UpdateRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
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
            'short_name' => $this->input('shortName'),
            

        ]);
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
            'short_name' => 'required|string',
        ];

        $this->isMethod('PUT') ? $this->applyUpdateRules($rules) : null;

        return $rules;
    }
}
