<?php

namespace App\Models\Finances;

use App\Models\Peoples\User;
use App\Models\Settings\Account;
use App\Models\Peoples\ExpensePeople;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanPaymentReceived extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'reference',
        'account_id',
        'loan_people_id',
        'user_id',
        'amount',
        'details'
    ];


    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($query) use ($search) {
            $query->where('date', 'like', '%' . $search . '%')
                ->orWhere('reference', 'like', '%' . $search . '%')
                ->orWhere('amount', 'like', '%' . $search . '%')
                ->orWhere('details', 'like', '%' . $search . '%')
                ->orWhereHas('account', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('loanPeople', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        });
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($purchase) {
            // Get the latest purchase that is not soft deleted
            $lastPurchase = self::withTrashed()->latest('id')->first();
            
            // Generate reference based on the latest purchase id
            $newId = $lastPurchase ? $lastPurchase->id + 1 : 1;
            $purchase->reference = 'PR_' . $newId;
        });
    }



    public function expensePeople()
    {
        return $this->belongsTo(ExpensePeople::class);
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
