<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdjustmentDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'adjustment_id',
        'productMaterial_id',
        'type',
        'kind',
        'amount',
    ];

    public function adjustment(){
        return $this->belongsTo(Adjustment::class);
    }
}
