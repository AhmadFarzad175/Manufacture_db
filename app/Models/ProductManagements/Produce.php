<?php

namespace App\Models\ProductManagements;

use App\Models\Settings\Product;
use App\Models\Settings\Warehouse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produce extends Model
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


    public function products()
    {
        return $this->belongsToMany(Product::class, 'produce_details')->withPivot('quantity')->withTimestamps();
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
