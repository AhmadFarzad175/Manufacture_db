<?php

namespace App\Models\Settings;

use App\Models\Purchases\Purchase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'image',
        'material_category_id',
        'unit_id',
        'cost',
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
                ->orWhere('cost', 'like', '%' . $search . '%')
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

    public function purchases()
    {
        return $this->belongsToMany(Purchase::class, 'purchase_details')->withPivot(['quantity', 'unit_cost'])->withTimestamps();
    }
}
