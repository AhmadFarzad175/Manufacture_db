<?php

namespace App\Http\Requests\Peoples;

use Illuminate\Foundation\Http\FormRequest;

class LoanPeopleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:loanPeoples,email|max:192',
            'phone' => 'required|string|max:15',
        ];
        $this->isMethod('PUT') ? $this->applyUpdateRules($rules) : null;

        return $rules;

    }
}
