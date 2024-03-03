<?php

namespace App\Models\Peoples;

use App\Models\Purchases\Purchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
