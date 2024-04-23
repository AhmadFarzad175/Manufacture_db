<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductManagements\Consume;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WarehouseMaterial extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'material_id',
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
                $query->whereHas('material', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('warehouse', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
    }


    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
