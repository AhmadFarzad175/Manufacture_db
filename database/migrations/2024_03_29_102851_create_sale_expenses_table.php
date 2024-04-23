<?php

use App\Models\Peoples\User;
use App\Models\Settings\Account;
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
        Schema::create('sale_expenses', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('reference')->unique();
            $table->foreignIdFor(ExpenseCategory::class)->constrained();
            $table->foreignIdFor(Account::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
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
        Schema::dropIfExists('sale_expenses');
    }
};
