<?php

use App\Models\Settings\Material;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\ProductManagements\Consume;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consume_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Material::class)->constrained();
            $table->foreignIdFor(Consume::class)->constrained();
            $table->integer('quantity');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consume_details');
    }
};
