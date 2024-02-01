<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'details'
    ];

    use HasFactory;

    public function paymentSends()
    {
        return $this->hasMany(PaymentSend::class);
    }

    public function paymentReceiveds()
    {
        return $this->hasMany(PaymentReceived::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
