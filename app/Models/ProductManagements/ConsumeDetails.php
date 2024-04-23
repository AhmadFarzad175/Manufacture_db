<?php

namespace App\Models\ProductManagements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsumeDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['material_id', 'quantity', 'consume_id'];
}
