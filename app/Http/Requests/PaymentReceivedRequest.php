<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class PaymentReceivedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function prepareForValidation()
    {
        $dataToMerge = [];

        // List of fields that can be updated
        $updateableFields = ['partyId', 'AddedById'];

        foreach ($updateableFields as $field) {
            if ($this->has($field)) {
                // If $field is 'AddedById', set 'user_id' in $dataToMerge
                $dataToMerge[$field === 'AddedById' ? 'user_id' : Str::snake($field)] = $this->input($field);
            }
        }

        $this->merge($dataToMerge);
    }



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $rules = [
            'date'        => 'required|date',
            'party_id'    => 'required|exists:parties,id',
            'user_id'     => 'required|integer',
            'received_amount' => 'required|integer',
            'details'     => 'nullable|string',
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
