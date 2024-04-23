<?php

use App\Models\Sales\Sale;
use App\Models\Peoples\User;
use App\Models\Settings\Account;
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
        Schema::create('sale_payments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('Reference', 192);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Sale::class)->constrained();
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
        Schema::dropIfExists('sale_payments');
    }
};
