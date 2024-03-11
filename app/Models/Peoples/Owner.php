<?php

namespace App\Models\Peoples;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;


    protected $fillable = ['name', 'email', 'phone', 'share', 'asset'];


    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->where('name', 'like', '%' . $search . '%')
            ->where('email', 'like', '%' . $search . '%')
            ->where('phone', 'like', '%' . $search . '%')
            ->where('share', 'like', '%' . $search . '%')
            ->where('asset', 'like', '%' . $search . '%');
    }
}
