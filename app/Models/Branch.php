<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    // public function employees()
    // {
    //     return $this->hasMany(Employee::class);
    // }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // public function departments()
    // {
    //     return $this->hasMany(Department::class);
    // }
}
