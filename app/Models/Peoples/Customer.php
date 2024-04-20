<?php

namespace App\Models\Peoples;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone'];


    // public function sales(){
    //     return $this->hasMany(Sale::class);
    // }

    // public function saleReturns(){
    //     return $this->hasMany(SaleReturn::class);
    // }
}
