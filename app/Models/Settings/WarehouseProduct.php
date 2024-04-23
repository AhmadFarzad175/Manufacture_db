<?php

namespace App\Models\Settings;

use App\Models\Settings\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WarehouseProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
    ];


    // public function consumes()
    // {
    //     return $this->hasMany(Produce::class);
    // }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
