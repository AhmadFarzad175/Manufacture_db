<?php

namespace App\Models\Settings;

use App\Models\Purchases\Purchase;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductManagements\Consume;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'image',
        'material_category_id',
        'unit_id',
        'cost',
        'stock',
        'stock_alert',
        'details',
    ];

    public function scopeSearch($query, $search, $wareHouse)
    {
        if (!$search && !$wareHouse) {
            return $query;
        }
        
        if($search){
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('code', 'like', '%' . $search . '%');         
            });
        } 
        if($wareHouse){
            $query->whereHas('warehouseMaterials', function($wareHouseQuery) use ($wareHouse) { 
                return $wareHouseQuery->where('warehouse_id', '=', $wareHouse);
        });

    }
    return $query;

}

    public function materialCategory()
    {
        return $this->belongsTo(MaterialCategory::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function consumes()
    {
        return $this->belongsToMany(Consume::class, 'consume_details')->withPivot('quantity')->withTimestamps();
    }

    public function warehouseMaterials()
    {
        return $this->hasMany(WarehouseMaterial::class);
    }

    public function purchases()
    {
        return $this->belongsToMany(Purchase::class, 'purchase_details')->withPivot(['quantity', 'unit_cost'])->withTimestamps();
    }
}
