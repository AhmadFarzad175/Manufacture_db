<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransferDetails extends Model
{
    use HasFactory, SoftDeletes;

    public function transfer(){
        return $this->belongsTo(Transfer::class);
    }
}
