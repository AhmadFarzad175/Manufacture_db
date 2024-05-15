<?php

namespace App\Models\Expenses;

use App\Models\Peoples\User;
use App\Models\Peoples\Supplier;
use App\Models\Settings\Currency;
use App\Models\Peoples\ExpensePeople;
use App\Models\Settings\ExpenseProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BillableExpense extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'date',
        'expense_people_id',
        'supplier_id',
        'user_id',
        'currency_id',
        'invoice_number',
        'paid',
        'total',
        'details'
    ];


    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($query) use ($search) {
            $query->where('date', 'like', '%' . $search . '%')
                ->orWhere('invoice_number', 'like', '%' . $search . '%')
                ->orWhere('paid', 'like', '%' . $search . '%')
                ->orWhere('total', 'like', '%' . $search . '%')
                ->orWhere('details', 'like', '%' . $search . '%')
                ->orWhereHas('expensePeople', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('supplier', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('currency', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        });
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($expense) {
            $expense->reference = 'BBE_' . (self::max('id') + 1);
        });
    }



    public function expensePeople()
    {
        return $this->belongsTo(ExpensePeople::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function expenseProduct()
    {
        return $this->belongsToMany(ExpenseProduct::class, 'billable_products')->withPivot(['quantity', 'price'])->withTimestamps();
    }
}
