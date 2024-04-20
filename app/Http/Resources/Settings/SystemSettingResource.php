<?php

namespace App\Http\Resources\Settings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SystemSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'companyName' => $this->companyName,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            // 'logo' => $this->logo,

        ];
    }
}
