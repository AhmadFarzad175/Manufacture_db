<?php

namespace App\Models\Purchases;

use App\Models\Peoples\Supplier;
use App\Models\Products\Material;
use App\Models\Settings\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{

    use HasFactory;

    protected $fillable = [
        'date',
        'user_id',
        'supplier_id',
        'paid',
        'total',
        'status',
        'shipping',
        'discount',
        'payment_type',
        'tax',
        'currency_id',
        'note',
    ];


    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->where('name', 'like', '%' . $search . '%');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($expense) {
            $expense->reference = 'PR_' . (self::max('id') + 1);
        });
    }


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'purchase_details')->withPivot(['quantity', 'unit_cost'])->withTimestamps();
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
}
