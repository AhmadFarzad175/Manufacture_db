<?php

use App\Models\Peoples\User;
use App\Models\Settings\Account;
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
        Schema::create('account_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_account_id')->constrained('accounts');

            // Foreign key for the to_account_id column
            $table->foreignId('to_account_id')->constrained('accounts');

            $table->foreignIdFor(User::class)->constrained();
            $table->integer('from_amount');
            $table->integer('to_amount');
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_transfers');
    }
};
