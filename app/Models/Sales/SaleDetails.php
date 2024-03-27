<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'material_id',
        'purchase_id',
        'quantity',
        'unit_cost',
    ];
}
