<?php

namespace App\Models\Expenses;

use App\Models\Peoples\ExpensePeople;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillablePayment extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'date',
        'expense_people_id',
        'amount',
        'details'
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
                ->orWhereHas('expensePeople', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        });
    }



    public function expensePeople()
    {
        return $this->belongsTo(ExpensePeople::class);
    }
}
