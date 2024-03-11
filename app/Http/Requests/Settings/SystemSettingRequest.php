<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class SystemSettingRequest extends FormRequest
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
            'email' => 'sometimes|string|email|max:192',
            'phone' => 'sometimes|string|max:15',
            'logo' => 'nullable',
            'address' => 'sometimes|string',
            'companyName' => 'sometimes|string',
        ];
    }
}
