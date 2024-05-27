<?php

namespace App\Models\Purchases;

use App\Models\Peoples\User;
use App\Models\Peoples\Supplier;
use App\Models\Settings\Currency;
use App\Models\Settings\Material;
use App\Models\Settings\Warehouse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date', 'user_id', 'warehouse_id', 'invoice_number', 'supplier_id', 'paid', 'total', 'status', 'shipping', 'discount', 'tax', 'currency_id', 'details',
    ];


    // Assuming the status attribute is an integer stored in the database
    protected $casts = [
        'status' => 'integer',
    ];

    // Define the accessor for the status attribute
    public function getStatusAttribute($value)
    {
        $statusMap = [
            0 => 'ordered',
            1 => 'pending',
            2 => 'received',
        ];

        return $statusMap[$value] ?? 'unknown';
    }
    


    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($query) use ($search) {
            $query->where('date', 'like', '%' . $search . '%')
                ->orWhere('supplier', 'like', '%' . $search . '%')
                ->orWhere('invoice_number', 'like', '%' . $search . '%')
                ->orWhere('paid', 'like', '%' . $search . '%')
                ->orWhere('total', 'like', '%' . $search . '%')
                ->orWhere('status', 'like', '%' . $search . '%')
                ->orWhere('shipping', 'like', '%' . $search . '%')
                ->orWhere('discount', 'like', '%' . $search . '%')
                ->orWhere('tax', 'like', '%' . $search . '%')
                ->orWhere('details', 'like', '%' . $search . '%')
                ->orWhereHas('warehouse', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('supplier', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('currency', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($purchase) {
            $purchase->reference = 'PR_' . (self::max('id') + 1);
        });
    }


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'purchase_details')->withPivot(['quantity', 'unit_cost'])->withTimestamps();
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function purchasePayments()
    {
        return $this->hasMany(PurchasePayment::class);
    }
}
