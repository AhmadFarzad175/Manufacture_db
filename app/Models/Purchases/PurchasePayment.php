<?php

namespace App\Models\Purchases;

use App\Models\Peoples\User;
use App\Models\Settings\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchasePayment extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'reference',
        'account_id',
        'purchase_id',
        'user_id',
        'amount',
        'details'
    ];


    public function scopeSearch($query, $search, $purchase)
    {
        if (!$search && !$purchase) {
            return $query;
        }

        if(!$search){
            $query->where(function ($query) use ($search) {
               $query->where('date', 'like', '%' . $search . '%')
                   ->orWhere('reference', 'like', '%' . $search . '%');
           });

        }

        if($purchase){
            $query->where('purchase_id', $purchase);
        };

        return $query;
    }


    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purhase()
    {
        return $this->belongsTo(Purchase::class);
    }
}

