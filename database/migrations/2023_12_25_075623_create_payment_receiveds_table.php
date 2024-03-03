<?php

use App\Models\Party;
use App\Models\User;
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
        Schema::create('payment_receiveds', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignIdFor(Party::class)->constrained()->unique(false);
            $table->foreignIdFor(User::class)->constrained()->unique(false);
            $table->string('reference')->unique();
            $table->decimal('amount', 20, 2)->default(0.00);
            $table->text('details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_receiveds');
    }
};
