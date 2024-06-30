<?php

namespace App\Models\Peoples;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\PaymentSent;
use App\Models\PaymentReceived;
use App\Models\Expenses\Expense;
use App\Models\Sales\SaleExpense;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Purchases\Purchase;
use App\Models\Expenses\BillableExpense;
use Illuminate\Notifications\Notifiable;
use App\Models\Purchases\PurchaseExpense;
use App\Models\Finances\ExpensePaymentSent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
        'email',
        'password',
        'phone',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }



    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
        });
    }


    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function payment_sents()
    {
        return $this->hasMany(PaymentSent::class);
    }

    public function payment_receiveds()
    {
        return $this->hasMany(PaymentReceived::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function billableExpenses()
    {
        return $this->hasMany(BillableExpense::class);
    }

    public function purchaseExpenses()
    {
        return $this->hasMany(PurchaseExpense::class);
    }

    public function saleExpenses()
    {
        return $this->hasMany(SaleExpense::class);
    }

    public function expensePaymentSents()
    {
        return $this->hasMany(ExpensePaymentSent::class);
    }
}
