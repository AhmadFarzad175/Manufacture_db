<?php

namespace App\Models\ProductManagements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProduceDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['product_id', 'quantity', 'produce_id'];
}
