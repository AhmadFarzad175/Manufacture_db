<?php

namespace App\Models\Settings;

use App\Models\Expenses\Expense;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchases\PurchaseExpense;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'details',
    ];


    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->where('name', 'like', '%' . $search . '%')
            ->where('details', 'like', '%' . $search . '%');
    }


    public function expenseProducts()
    {
        return $this->hasMany(ExpenseProduct::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function purchaseExpenses()
    {
        return $this->hasMany(PurchaseExpense::class);
    }
}
