<?php


use App\Models\Peoples\User;
use App\Models\Peoples\ExpensePeople;
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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->date('date');
            $table->foreignIdFor(ExpenseCategory::class)->constrained();
            $table->foreignIdFor(ExpensePeople::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->decimal('amount', 20, 2)->default(0.00);
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
