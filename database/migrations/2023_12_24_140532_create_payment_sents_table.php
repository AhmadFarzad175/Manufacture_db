<?php

use App\Models\Peoples\User;
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
        Schema::create('payment_sents', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignIdFor(User::class)->constrained();
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
        Schema::dropIfExists('payment_sents');
    }
};
