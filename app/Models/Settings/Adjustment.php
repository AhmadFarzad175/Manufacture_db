<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Adjustment extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'warehouse_id',
        'details',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($adjustment) {
            $adjustment->reference = 'ADJ_' . (self::max('id') + 1);
        });
    }



    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($query) use ($search) {
            $query->where('date', 'like', '%' . $search . '%')
                ->orWhere('reference', 'like', '%' . $search . '%')
                ->orWhere('details', 'like', '%' . $search . '%')
                ->orWhereHas('warehouse', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        });
    }

    public function warehouse(){
        return $this->belongsTo(Warehouse::class);
    }

    public function adjustmentDetails(){
        return $this->hasMany(AdjustmentDetails::class);
    }
}
