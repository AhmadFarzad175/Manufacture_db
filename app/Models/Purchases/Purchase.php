<?php

namespace App\Models\Purchases;

use App\Models\User;
use App\Models\Peoples\Supplier;
use App\Models\Settings\Currency;
use App\Models\Settings\Material;
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
        'tax',
        'currency_id',
        'note',
    ];

    //FINDING AND STORING THE DUE VALUE
    public function getDueAttribute()
    {
        return $this->total - $this->paid;
    }


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
