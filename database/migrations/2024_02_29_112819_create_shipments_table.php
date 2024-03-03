<?php

use App\Models\User;
use App\Models\Purchases\Purchase;
use Illuminate\Support\Facades\DB;
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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('Ref', 192);
            $table->foreignIdFor(Purchase::class);
            $table->string('delivered_to', 192)->nullable();
            $table->text('address')->nullable();
            $table->string('shipmentStatus', 192);
            $table->text('details')->nullable();
            $table->timestamps(6);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
