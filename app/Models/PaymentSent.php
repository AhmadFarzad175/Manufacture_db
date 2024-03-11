<?php

namespace App\Models;

use App\Models\Peoples\User;
use App\Models\Peoples\ExpensePeople;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentSent extends Model
{
    protected $fillable = [
        'date',
        'expense_people_id',
        'user_id',
        'amount',
        'details',
        'reference'
    ];
    use HasFactory;



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

        static::creating(function ($payment_sent) {
            $payment_sent->reference = 'SENT_' . (self::max('id') + 1);
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
