<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transfer extends Model

{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'from_warehouse_id',
        'to_warehouse_id',
        'total',
        'status',
        'shipping',
        'discount',
        'tax',
        'details',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transfer) {
            $transfer->reference = 'TRN_' . (self::max('id') + 1);
        });
    }



    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($query) use ($search) {
            $query->where('date', 'like', '%' . $search . '%')
                ->orWhere('total', 'like', '%' . $search . '%')
                ->orWhere('status', 'like', '%' . $search . '%')
                ->orWhere('shipping', 'like', '%' . $search . '%')
                ->orWhere('discount', 'like', '%' . $search . '%')
                ->orWhere('tax', 'like', '%' . $search . '%')
                ->orWhere('details', 'like', '%' . $search . '%')
                ->orWhereHas('fromWarehouse', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('toWarehouse', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('customer', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('currency', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        });
    }

    public function fromWarehouse(){
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id', 'id');
    }

    public function toWarehouse(){
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id', 'id');
    }

    public function transferDetails(){
        return $this->hasMany(TransferDetails::class);
    }

    
}
