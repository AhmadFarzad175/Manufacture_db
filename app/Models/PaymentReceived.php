<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReceived extends Model
{
    protected $fillable = [
        'date',
        'party_id',
        'user_id',
        'received_amount',
        'details',
    ];

    use HasFactory;

    public function party()
    {
        return $this->belongsTo(Party::class);
    }
}
