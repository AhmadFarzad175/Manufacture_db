<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemSetting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'companyName',
        'logo',
        'email',
        'phone',
        'address',
    ];
}
