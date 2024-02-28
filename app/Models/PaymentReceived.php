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
        'amount',
        'details',
        'reference'
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

        static::creating(function ($payment_Received) {
            $payment_Received->reference = 'REC_' . (self::max('id') + 1);
        });
    }


    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
