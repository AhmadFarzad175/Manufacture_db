<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use App\Models\Expenses\BillableExpense;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'image',
        'expense_category_id',
        'unit_id',
        'price',
        'stock',
        'stock_alert',
        'details',
    ];

    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('code', 'like', '%' . $search . '%')
                ->orWhere('price', 'like', '%' . $search . '%')
                ->orWhere('stock_alert', 'like', '%' . $search . '%')
                ->orWhere('details', 'like', '%' . $search . '%')
                ->orWhere(function ($query) use ($search) {
                    $query->whereHas('unit', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })
                        ->orWhereHas('expenseCategory', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        });
                });
        });
    }


    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function billableExpense()
    {
        return $this->belongsToMany(BillableExpense::class, 'billable_products')->withPivot(['quantity', 'price'])->withTimestamps();
    }
}
