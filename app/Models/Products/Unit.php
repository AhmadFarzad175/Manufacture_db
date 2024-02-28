<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description"
    ];

    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->where('name', 'like', '%' . $search . '%');
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
