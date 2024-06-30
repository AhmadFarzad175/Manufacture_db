<?php

namespace App\Models\Sales;

use App\Models\Peoples\User;
use App\Models\Settings\Account;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\ExpenseCategory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleExpense extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'reference',
        'sale_id',
        'account_id',
        'expense_category_id',
        'user_id',
        'amount',
        'details'
    ];


    public function scopeSearch($query, $search, $sale)
    {
        if (!$search && !$sale) {
            return $query;
        }

        if($search){
         $query->where(function ($query) use ($search) {
            $query->where('date', 'like', '%' . $search . '%')
                ->orWhere('reference', 'like', '%' . $search . '%')
                ->orWhere('amount', 'like', '%' . $search . '%')
                ->orWhere('details', 'like', '%' . $search . '%')
                ->orWhereHas('account', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('category', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        });
    }

        if($sale){
            $query->where('sale_id', $sale);
        };
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($saleExpense) {
            // Get the latest saleExpense that is not soft deleted
            $lastSaleExpense = self::withTrashed()->latest('id')->first();
            
            // Generate reference based on the latest saleExpense id
            $newId = $lastSaleExpense ? $lastSaleExpense->id + 1 : 1;
            $saleExpense->reference = 'SAE_' . $newId;
        });

    }


    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
