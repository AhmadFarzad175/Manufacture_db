<?php

namespace App\Models\Peoples;

use App\Models\Expenses\Expense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpensePeople extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone'];
    protected $table = 'expense_peoples';

    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->where('name', 'like', '%' . $search . '%')
            ->where('email', 'like', '%' . $search . '%')
            ->where('phone', 'like', '%' . $search . '%');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
