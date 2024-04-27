<?php

namespace App\Models\Settings;

use App\Models\Purchases\Purchase;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductManagements\Consume;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'city',
        'country',
    ];


    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('phone', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('city', 'like', '%' . $search . '%')
            ->orWhere('country', 'like', '%' . $search . '%');
    }

    public function consumes()
    {
        return $this->hasMany(Consume::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }

}
