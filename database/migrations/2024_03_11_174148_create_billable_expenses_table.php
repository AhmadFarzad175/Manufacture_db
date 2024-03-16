<?php

use App\Models\Peoples\User;
use App\Models\Peoples\Supplier;
use App\Models\Settings\Currency;
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
        Schema::create('billable_expenses', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('reference')->unique();
            $table->foreignIdFor(ExpensePeople::class)->constrained();
            $table->foreignIdFor(Supplier::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->integer('invoice_number');
            $table->decimal('paid', 20, 2);
            $table->decimal('total', 20, 2);
            $table->decimal('due', 20, 2);
            $table->foreignIdFor(Currency::class)->constrained();
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
        Schema::dropIfExists('billable_expenses');
    }
};
