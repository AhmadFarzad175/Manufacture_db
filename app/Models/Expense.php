<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_category_id',
        'date',
        'amount',
        'user_id',
        'party_id',
        'branch_id',
        'details',
        'reference'
    ];


    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->where('name', 'like', '%' . $search . '%');
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

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
