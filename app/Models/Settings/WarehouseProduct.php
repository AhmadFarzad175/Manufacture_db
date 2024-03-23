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


    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere(function ($query) use ($search) {
                $query->whereHas('product', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('warehouse', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
    }

    // public function consumes()
    // {
    //     return $this->hasMany(Produce::class);
    // }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
