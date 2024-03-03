<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Party;
use App\Models\Branch;
use App\Models\Expense;
use App\Models\PaymentSent;
use App\Models\Products\Unit;
use App\Models\ExpenseCategory;
use App\Models\PaymentReceived;
use Illuminate\Database\Seeder;
use App\Models\Peoples\Supplier;
use App\Models\Products\Product;
use App\Models\Products\Material;
use App\Models\Settings\Currency;
use App\Models\Purchases\Purchase;
use App\Models\Products\MaterialCategory;
use App\Models\Purchases\PurchaseDetail;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Currency::factory(3)->create();
        User::factory(10)->create();
        Branch::factory(10)->create();

        Supplier::factory(10)->create();

        //! EXPENSE
        Party::factory(10)->create();
        ExpenseCategory::factory(10)->create();
        Expense::factory(10)->create();
        PaymentSent::factory(10)->create();
        PaymentReceived::factory(10)->create();

        //! Product
        MaterialCategory::factory(10)->create();
        Unit::factory(10)->create();
        Material::factory(10)->create();
        Product::factory(10)->create();

        //! Purchase
        Purchase::factory(10)->create();
        PurchaseDetail::factory(10)->create();
    }
}
