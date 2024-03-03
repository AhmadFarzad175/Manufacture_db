<?php

namespace App\Models\Settings;

use App\Models\Purchases\Purchase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
