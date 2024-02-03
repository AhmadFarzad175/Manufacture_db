<?php

use App\Models\Party;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->integer('user_id');
            $table->integer('sent_amount');
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
