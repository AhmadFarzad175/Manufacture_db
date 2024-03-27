<?php

namespace App\Models\Peoples;

use App\Models\Sales\Sale;
use App\Models\Purchases\Purchase;
use Illuminate\Database\Eloquent\Model;
use App\Models\Expenses\BillableExpense;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'email', 'phone'];


    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->where('name', 'like', '%' . $search . '%')
            ->where('email', 'like', '%' . $search . '%')
            ->where('phone', 'like', '%' . $search . '%');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    

    public function billableExpenses()
    {
        return $this->hasMany(BillableExpense::class);
    }
}
