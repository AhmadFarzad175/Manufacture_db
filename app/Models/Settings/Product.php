<?php

namespace App\Models\Settings;

use App\Models\Sales\Sale;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductManagements\Produce;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'image',
        'material_category_id',
        'unit_id',
        'price',
        'stock',
        'stock_alert',
        'description',
    ];

    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('code', 'like', '%' . $search . '%')
                ->orWhere('price', 'like', '%' . $search . '%')
                ->orWhere('stock_alert', 'like', '%' . $search . '%')
                ->orWhere(function ($query) use ($search) {
                    $query->whereHas('unit', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })
                        ->orWhereHas('materialCategory', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        });
                });
        });
    }


    public function materialCategory()
    {
        return $this->belongsTo(MaterialCategory::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function warehouseProducts()
    {
        return $this->hasMany(WarehouseProduct::class);
    }

    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_details')->withPivot(['quantity', 'unit_cost'])->withTimestamps();
    }

    public function produces()
    {
        return $this->belongsToMany(Produce::class, 'produce_details')->withPivot('quantity')->withTimestamps();
    }
}

