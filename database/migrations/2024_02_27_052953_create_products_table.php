<?php

use App\Models\Settings\Unit;
use Illuminate\Support\Facades\Schema;
use App\Models\Settings\MaterialCategory;
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
            $table->string('code');
            $table->string('name');
            $table->string('image')->nullable();
            $table->foreignIdFor(MaterialCategory::class)->constrained();
            $table->foreignIdFor(Unit::class)->constrained();
            $table->decimal('price', 20, 2);
            // $table->decimal('stock', 10, 2)->nullable()->default(0.00);
            $table->integer('stock')->nullable()->default(0);
            $table->integer('stock_alert');
            $table->text('details')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
