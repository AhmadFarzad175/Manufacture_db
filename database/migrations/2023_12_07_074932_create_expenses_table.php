<?php

use App\Models\User;
use App\Models\Party;
use App\Models\Branch;
use App\Models\Company;
use App\Models\ExpenseCategory;
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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->date('date');
            // $table->foreignIdFor(ExpenseCategory::class)->constrained();
            $table->decimal('amount', 20, 2)->default(0.00);
            $table->foreignIdFor(Party::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Branch::class)->constrained();
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
