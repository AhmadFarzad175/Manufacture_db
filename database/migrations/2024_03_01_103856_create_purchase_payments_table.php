<?php

use App\Models\Peoples\User;
use App\Models\Settings\Account;
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
            $table->date('date');
            $table->string('Reference', 192);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Purchase::class)->constrained();
            $table->foreignIdFor(Account::class)->constrained();
            $table->decimal('amount', 20, 2);
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
        Schema::dropIfExists('purchase_payments');
    }
};
