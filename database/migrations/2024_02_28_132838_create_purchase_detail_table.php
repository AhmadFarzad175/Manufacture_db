<?php

use App\Models\Settings\Material;
use App\Models\Purchases\Purchase;
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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Material::class);
            $table->foreignIdFor(Purchase::class);
            $table->integer('quantity');
            $table->decimal('unit_cost', 20, 2);
            $table->timestamps();
        });
    }

    //     ID
    // material_id
    // quantity
    // unit_cost
    // purchase_id


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
