<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use App\Models\Purchases\PurchaseExpense;
use App\Models\Sales\SalePayment;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'currency_id',
        'price',
    ];


    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('price', 'like', '%' . $search . '%')
                ->orWhereHas('currency', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        });
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function sentTransfers()
    {
        return $this->hasMany(AccountTransfer::class, 'from_account_id');
    }

    // Relationship: account has many transfers where it is the receiver
    public function receivedTransfers()
    {
        return $this->hasMany(AccountTransfer::class, 'to_account_id');
    }

    public function purchaseExpenses()
    {
        return $this->hasMany(PurchaseExpense::class);
    }
    
    public function salePayment()
    {
        return $this->hasMany(SalePayment::class);
    }
}
