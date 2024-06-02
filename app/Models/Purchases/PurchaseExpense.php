<?php

namespace App\Models\Purchases;

use App\Models\Peoples\User;
use App\Models\Settings\Account;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\ExpenseCategory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseExpense extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'reference',
        'purchase_id',
        'account_id',
        'expense_category_id',
        'user_id',
        'amount',
        'details'
    ];


    public function scopeSearch($query, $search, $purchase)
    {
        if (!$search && !$purchase) {
            return $query;
        }

        if($search){
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


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($purchaseExpense) {
            // Get the latest purchase$purchaseExpense that is not soft deleted
            $lastPurchase = self::withTrashed()->latest('id')->first();

            // Generate reference based on the latest purchase$purchaseExpense id
            $newId = $lastPurchase ? $lastPurchase->id + 1 : 1;
            $purchaseExpense->reference = 'PRE_' . $newId;
        });
    }


    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
