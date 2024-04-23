<?php

namespace App\Traits;

use App\Traits\IsUpdateRequestRulesIfNeeded;

trait StoreProductRequest
{
    use IsUpdateRequestRulesIfNeeded;

    public function prepareForValidation()
    {
        $this->merge([
            'agent_code' => $this->input('agentCode')
        ]);
    }

    protected function branchRequestRules($isUpdate = false)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'address' => 'string',
        ];

        return $this->applyUpdateRulesIfNeeded($rules, $isUpdate);
    }
}
