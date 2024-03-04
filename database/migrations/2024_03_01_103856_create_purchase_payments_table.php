<?php

use App\Models\User;
use App\Models\Settings\Account;
use App\Models\Settings\Currency;
use App\Models\Purchases\Purchase;
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
        Schema::create('purchase_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->date('date');
            $table->string('Reference', 192);
            $table->foreignIdFor(Purchase::class);
            $table->string('payment_type');
            $table->decimal('paid', 20, 2)->nullable()->default(0.00);
            $table->foreignIdFor(Account::class);
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_payments');
    }
};
