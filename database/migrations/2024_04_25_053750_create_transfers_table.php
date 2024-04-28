<?php

use App\Models\Settings\Warehouse;
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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('reference')->unique();
            $table->foreignId('from_warehouse_id')->references('id')->on('warehouses');
            $table->foreignId('to_warehouse_id')->references('id')->on('warehouses');
            $table->decimal('total', 20, 2);
            $table->integer('status'); // 0:pending 1:completed 2:sent
            $table->decimal('shipping', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->decimal('tax', 10, 2);
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
        Schema::dropIfExists('transfers');
    }
};
