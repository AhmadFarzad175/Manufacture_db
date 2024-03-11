<?php

namespace App\Models\Peoples;

use App\Models\Purchases\Purchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
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

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
