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
            $table->foreignIdFor(ExpenseCategory::class)->constrained()->unique(false);
            $table->integer('amount')->default(0);
            $table->foreignIdFor(Party::class)->constrained()->unique(false);
            $table->foreignIdFor(User::class)->constrained()->unique(false);
            $table->foreignIdFor(Branch::class)->constrained()->unique(false);
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
