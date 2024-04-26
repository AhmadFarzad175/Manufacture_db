<?php

use App\Models\Settings\Transfer;
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
        Schema::create('transfer_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Transfer::class)->constrained();
            $table->integer('productMaterial_id');
            $table->integer('type');    // 0:material    1:product
            $table->integer('quantity');
            $table->decimal('unit_cost', 20, 2);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_details');
    }
};
