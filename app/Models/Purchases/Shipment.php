<?php

namespace App\Models\Purchases;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
    use HasFactory, SoftDeletes;

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
