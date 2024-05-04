<?php

use App\Models\Settings\Adjustment;
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
        Schema::create('adjustment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Adjustment::class)->constrained();
            $table->integer('productMaterial_id');
            $table->boolean('type');    // 0:addition    1:subtraction
            $table->boolean('kind');    // 0:material    1:product
            $table->integer('amount');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjustment_details');
    }
};
