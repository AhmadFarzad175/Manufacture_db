<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class AccountTransferRequest extends FormRequest
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
            'from_account' => 'required|exists:accounts,id',
            'to_account' => 'required|exists:accounts,id',
            'user_id' => 'required|exists:users,id',
            'from_amount' => 'required|integer|min:0',
            'to_amount' => 'required|integer|min:0',
            'date' => 'required|date',
        ];
    }
}
