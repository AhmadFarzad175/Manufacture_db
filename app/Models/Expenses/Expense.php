<?php

namespace App\Models\Expenses;

use App\Models\Peoples\User;
use App\Models\Peoples\ExpensePeople;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\ExpenseCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'expense_category_id',
        'amount',
        'user_id',
        'expense_people_id',
        'details',
    ];


    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($query) use ($search) {
            $query->where('date', 'like', '%' . $search . '%')
                ->orWhere('amount', 'like', '%' . $search . '%')
                ->orWhere('details', 'like', '%' . $search . '%')
                ->orWhereHas('expenseCategory', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('expensePeople', function ($query) use ($search) {
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

        static::creating(function ($expense) {
            $expense->reference = 'EXP_' . (self::max('id') + 1);
        });
    }


    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class);
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
