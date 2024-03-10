<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Party;
use App\Models\Branch;
use App\Models\Expense;
use App\Models\PaymentSent;
use App\Models\Settings\Unit;
use App\Models\PaymentReceived;
use Illuminate\Database\Seeder;
use App\Models\Peoples\Customer;
use App\Models\Peoples\Supplier;
use App\Models\Settings\Account;
use App\Models\Settings\Product;
use App\Models\Settings\Currency;
use App\Models\Settings\Material;
use App\Models\Purchases\Purchase;
use App\Models\Settings\Warehouse;
use App\Models\Settings\SystemSetting;
use App\Models\Settings\ExpenseProduct;
use App\Models\Purchases\PurchaseDetail;
use App\Models\Settings\AccountTransfer;
use App\Models\Settings\ExpenseCategory;
use App\Models\Settings\MaterialCategory;
use App\Models\Settings\WarehouseProduct;

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

        //* SETTING
        $this->call(SystemSettingsTableSeeder::class);
        Currency::factory(5)->create();
        Account::factory(5)->create();
        AccountTransfer::factory(10)->create();
        Warehouse::factory(10)->create();
        MaterialCategory::factory(10)->create();
        Unit::factory(10)->create();
        Product::factory(10)->create();
        Material::factory(10)->create();
        ExpenseCategory::factory(10)->create();
        ExpenseProduct::factory(10)->create();


        User::factory(10)->create();
        Branch::factory(10)->create();

        Customer::factory(10)->create();
        Supplier::factory(10)->create();

        //! EXPENSE
        // Party::factory(10)->create();
        // Expense::factory(10)->create();
        // PaymentSent::factory(10)->create();
        // PaymentReceived::factory(10)->create();


        //! Purchase
        Purchase::factory(10)->create();
        PurchaseDetail::factory(10)->create();
    }
}
