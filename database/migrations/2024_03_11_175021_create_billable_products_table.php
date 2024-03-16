<?php

use Illuminate\Support\Facades\Schema;
use App\Models\Settings\ExpenseProduct;
use App\Models\Expenses\BillableExpense;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    //PIVOT TABLE:
    public function up(): void
    {
        Schema::create('billable_products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ExpenseProduct::class)->constrained();
            $table->foreignIdFor(BillableExpense::class)->constrained();
            $table->integer('quantity');
            $table->decimal('price', 20, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billable_products');
    }
};
