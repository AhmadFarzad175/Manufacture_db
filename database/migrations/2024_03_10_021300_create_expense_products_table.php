<?php

use App\Models\Settings\Unit;
use Illuminate\Support\Facades\Schema;
use App\Models\Settings\ExpenseCategory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expense_products', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('image')->nullable();
            $table->foreignIdFor(ExpenseCategory::class)->constrained();
            $table->foreignIdFor(Unit::class)->constrained();
            $table->decimal('price', 20, 2);
            $table->integer('stock')->default(0);
            $table->integer('stock_alert');
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
        Schema::dropIfExists('expense_products');
    }
};
