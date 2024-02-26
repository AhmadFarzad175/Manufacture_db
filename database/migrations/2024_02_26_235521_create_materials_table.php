<?php

use App\Models\Unit;
use App\Models\MaterialCategory;
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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->foreignIdFor(MaterialCategory::class);
            $table->foreignIdFor(Unit::class);
            $table->float('cost', 10, 0);
            $table->float('stock', 10, 0)->nullable()->default(0);
            $table->float('stock_alert', 10, 0)->nullable()->default(0);
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
