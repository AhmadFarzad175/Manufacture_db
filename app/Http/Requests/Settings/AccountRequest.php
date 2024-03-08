<?php

namespace App\Http\Requests\Settings;

use App\Traits\UpdateRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    use UpdateRequestRules;
    /**
     * 
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {

        if ($this->input('currencyId') !== null) {
            return $this->merge([
                'currency_id' => $this->input('currencyId'),
            ]);
        }
        return $this;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'currency_id' => 'required|exists:currencies,id',
            'price' => 'required|numeric|min:0',
        ];

        $this->isMethod('PUT') ? $this->applyUpdateRules($rules) : null;

        return $rules;
    }
}
