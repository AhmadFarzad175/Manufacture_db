<?php

namespace App\Models\Purchases;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
