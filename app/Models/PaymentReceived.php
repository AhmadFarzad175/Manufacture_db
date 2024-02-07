<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReceived extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'party_id',
        'user_id',
        'received_amount',
        'details',
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
            $expense->reference = 'EXP_' . (self::max('id') + 1);
        });
    }
    

    public function party()
    {
        return $this->belongsTo(Party::class);
    }
}
