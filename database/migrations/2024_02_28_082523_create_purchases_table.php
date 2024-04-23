<?php

use App\Models\Peoples\User;
use App\Models\Peoples\Supplier;
use App\Models\Settings\Currency;
use App\Models\Purchases\Shipment;
use App\Models\Settings\Warehouse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Warehouse::class)->constrained();
            $table->integer('invoice_number');
            $table->foreignIdFor(Supplier::class)->constrained();
            $table->string('reference')->unique();
            $table->decimal('total', 20, 2);
            $table->decimal('paid', 20, 2)->nullable()->default(0.00);
            $table->string('status');
            $table->decimal('shipping', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->foreignIdFor(Currency::class)->constrained();
            $table->text('details')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    // status
    // 1. received
    // 2. pending
    // 3. ordered

    // payment type
    // 1.cash
    // 2.bank transfer
    // 3.credit card
    // 4.others


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
