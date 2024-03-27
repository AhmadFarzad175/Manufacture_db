<?php

namespace App\Models\Sales;

use App\Models\Peoples\User;
use App\Models\Peoples\Customer;
use App\Models\Peoples\Supplier;
use App\Models\Settings\Product;
use App\Models\Settings\Currency;
use App\Models\Settings\Material;
use App\Models\Purchases\Shipment;
use App\Models\Settings\Warehouse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'user_id',
        'warehouse_id',
        'invoice_number',
        'customer_id',
        'paid',
        'total',
        'status',
        'shipping',
        'discount',
        'tax',
        'currency_id',
        'details',
    ];


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
                ->orWhereHas('customer', function ($query) use ($search) {
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

        static::creating(function ($sale) {
            $sale->reference = 'SEL_' . (self::max('id') + 1);
        });

    }


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_details')->withPivot(['quantity', 'unit_cost'])->withTimestamps();
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

    // public function purchasePayments()
    // {
    //     return $this->hasMany(PurchasePayment::class);
    // }
}
