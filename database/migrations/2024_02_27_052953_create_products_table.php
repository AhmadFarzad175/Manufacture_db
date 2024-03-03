<?php

use App\Models\Products\Unit;
use Illuminate\Support\Facades\Schema;
use App\Models\Products\MaterialCategory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->string('name');
            $table->string('image');
            $table->foreignIdFor(MaterialCategory::class);
            $table->foreignIdFor(Unit::class);
            $table->decimal('price', 20, 2);
            $table->decimal('stock', 10, 2)->nullable()->default(0.00);
            $table->decimal('stock_alert', 10, 2)->nullable()->default(0.00);
            $table->boolean('tax_type')->default(0);
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
