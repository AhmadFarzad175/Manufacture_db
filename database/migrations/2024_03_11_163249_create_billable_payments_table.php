<?php

use App\Models\Peoples\ExpensePeople;
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
        Schema::create('billable_payments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('amount', 20, 2)->default(0.00);
            $table->foreignIdFor(ExpensePeople::class)->constrained();
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
        Schema::dropIfExists('billable_payments');
    }
};
