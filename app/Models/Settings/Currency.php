<?php

namespace App\Models\Settings;

use App\Models\Purchases\Purchase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'code',
        'name',
        'symbol',
        'rate'
    ];


    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('code', 'like', '%' . $search . '%')
            ->orWhere('symbol', 'like', '%' . $search . '%')
            ->orWhere('rate', 'like', '%' . $search . '%');
    }



    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function billableExpense()
    {
        return $this->hasMany(Purchase::class);
    }


    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
