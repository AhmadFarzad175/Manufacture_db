<?php

namespace App\Models;

use App\Models\Peoples\User;
use App\Models\Peoples\ExpensePeople;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentReceived extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'date',
        'expense_people',
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


    public function expensePeople()
    {
        return $this->belongsTo(ExpensePeople::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
