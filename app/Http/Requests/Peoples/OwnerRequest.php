<?php

namespace App\Http\Requests\Peoples;

use App\Traits\UpdateRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class OwnerRequest extends FormRequest
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
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:owners,email|max:192',
            'phone'  => 'required|string|max:15',
            'share'  => 'required|numeric|min:0|max:100',
            'asset'  => 'required|numeric|min:0',
        ];

        $this->isMethod('PUT') ? $this->applyUpdateRules($rules) : null;

        return $rules;
    }
}
