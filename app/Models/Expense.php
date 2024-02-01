<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'expense_category_id',
        'date',
        'amount',
        'user_id',
        'party_id',
        'branch_id',
        'details',
    ];

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
}
