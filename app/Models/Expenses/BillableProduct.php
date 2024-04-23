<?php

namespace App\Models\Expenses;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BillableProduct extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'expense_product_id',
        'billable_expense_id',
        'quantity',
        'price'
    ];
}
