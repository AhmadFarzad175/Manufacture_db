<?php

namespace App\Models\Finances;

use App\Models\Peoples\User;
use App\Models\Peoples\Owner;
use App\Models\Settings\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OwnerPaymentSent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'reference',
        'account_id',
        'owner_id',
        'user_id',
        'amount',
        'details'
    ];


    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($query) use ($search) {
            $query->where('date', 'like', '%' . $search . '%')
                ->orWhere('reference', 'like', '%' . $search . '%')
                ->orWhere('amount', 'like', '%' . $search . '%')
                ->orWhere('details', 'like', '%' . $search . '%')
                ->orWhereHas('account', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('owner', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        });
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ownerPaymentSent) {
            $ownerPaymentSent->reference = 'OPS_' . (self::max('id') + 1);
        });
    }



    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
