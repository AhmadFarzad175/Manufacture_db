<?php

namespace App\Models\Peoples;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

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

    // public function sales(){
    //     return $this->hasMany(Sale::class);
    // }

    // public function saleReturns(){
    //     return $this->hasMany(SaleReturn::class);
    // }
}
