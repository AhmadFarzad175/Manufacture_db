<?php

namespace App\Models\ProductManagements;

use App\Models\Settings\Material;
use App\Models\Settings\Warehouse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consume extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['date', 'warehouse_id', 'details'];


    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->where('date', 'like', '%' . $search . '%')
            ->orWhereHas('warehouse', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
    }


    public function materials()
    {
        return $this->belongsToMany(Material::class, 'consume_details')->withPivot('quantity')->withTimestamps();
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
