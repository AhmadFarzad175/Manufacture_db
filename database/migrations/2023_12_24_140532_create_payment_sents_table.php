<?php

use App\Models\User;
use App\Models\Party;
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
            $table->foreignIdFor(Party::class)->constrained()->unique(false);
            $table->foreignIdFor(User::class)->constrained()->unique(false);
            $table->string('reference')->unique();
            $table->integer('amount');
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
