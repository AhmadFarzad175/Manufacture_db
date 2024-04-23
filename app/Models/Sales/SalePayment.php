<?php

namespace App\Models\Sales;

use App\Models\Peoples\User;
use App\Models\Settings\Account;
use App\Models\Purchases\Purchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalePayment extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'reference',
        'user_id',
        'sale_id',
        'account_id',
        'amount',
        'details',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sale) {
            $sale->reference = 'SPAY_' . (self::max('id') + 1);
        });

    }




    public function sales()
    {
        return $this->belongsTo(Sale::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

}
