<?php

use App\Models\Peoples\User;
use App\Models\Peoples\Customer;
use App\Models\Settings\Currency;
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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Warehouse::class)->constrained();
            $table->integer('invoice_number');
            $table->foreignIdFor(Customer::class)->constrained();
            $table->string('reference')->unique();
            $table->decimal('total', 20, 2);
            $table->decimal('paid', 20, 2);
            $table->string('status');
            $table->decimal('shipping', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->decimal('tax', 10, 2);
            // $table->foreignIdFor(Currency::class)->constrained();
            $table->foreignIdFor(Currency::class)->nullable();
            $table->text('details')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
