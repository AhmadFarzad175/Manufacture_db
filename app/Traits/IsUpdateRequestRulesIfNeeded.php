<?php

namespace App\Traits;

trait IsUpdateRequestRulesIfNeeded
{
    protected function applyUpdateRulesIfNeeded($rules, $isUpdate)
    {
        if ($isUpdate) {
            $rules = array_map(function ($rule) {
                return str_replace('required', 'sometimes', $rule);
            }, $rules);
        }
        return $rules;
    }
}
