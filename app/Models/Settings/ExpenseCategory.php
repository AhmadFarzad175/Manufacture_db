<?php

namespace App\Models\Settings;

use App\Models\Expenses\Expense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];


    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->where('name', 'like', '%' . $search . '%')
            ->where('description', 'like', '%' . $search . '%');
    }


    public function expenseProducts()
    {
        return $this->hasMany(ExpenseProduct::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
