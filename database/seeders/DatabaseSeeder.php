<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Branch;
use App\Models\Sales\Sale;
use App\Models\Peoples\User;
use App\Models\Peoples\Owner;
use App\Models\Settings\Unit;
use Illuminate\Database\Seeder;
use App\Models\Expenses\Expense;
use App\Models\Peoples\Customer;
use App\Models\Peoples\Supplier;
use App\Models\Settings\Account;
use App\Models\Settings\Product;
use App\Models\Sales\SaleDetails;
use App\Models\Sales\SaleExpense;
use App\Models\Sales\SalePayment;
use App\Models\Settings\Currency;
use App\Models\Settings\Material;
use App\Models\Peoples\LoanPeople;
use App\Models\Purchases\Purchase;
use App\Models\Settings\Warehouse;
use App\Models\Peoples\ExpensePeople;
use App\Models\Settings\SystemSetting;
use App\Models\Settings\ExpenseProduct;
use App\Models\Expenses\BillableExpense;
use App\Models\Expenses\BillablePayment;
use App\Models\Expenses\BillableProduct;
use App\Models\Finances\LoanPaymentSent;
use App\Models\Purchases\PurchaseDetail;
use App\Models\Settings\AccountTransfer;
use App\Models\Settings\ExpenseCategory;
use App\Models\Finances\OwnerPaymentSent;
use App\Models\Purchases\PurchaseExpense;
use App\Models\Purchases\PurchasePayment;
use App\Models\Settings\MaterialCategory;
use App\Models\Settings\WarehouseProduct;
use App\Models\ProductManagements\Consume;
use App\Models\ProductManagements\Produce;
use App\Models\Settings\WarehouseMaterial;
use App\Models\Finances\ExpensePaymentSent;
use App\Models\Finances\LoanPaymentReceived;
use App\Models\Finances\OwnerPaymentReceived;
use App\Models\Finances\ExpensePaymentReceived;
use App\Models\ProductManagements\ConsumeDetails;
use App\Models\ProductManagements\ProduceDetails;

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

        User::factory(10)->create();
        SystemSetting::create([
            'companyName' => 'Your Company',
            'email' => 'your@email.com',
            'phone' => '123-456-7890',
            'logo' => 'setting_logos//g9Jn7KFsWVQl1GkN0zo8y50JzWc4iNuSLR1wp5YT.png', // Provide a default logo path
            'address' => 'Your Company Address',
        ]);
        Currency::factory(10)->create();
        Account::factory(10)->create();
        AccountTransfer::factory(10)->create();
        Warehouse::factory(10)->create();
        MaterialCategory::factory(10)->create();
        Unit::factory(10)->create();
        Product::factory(10)->create();
        Material::factory(10)->create();
        ExpenseCategory::factory(10)->create();
        ExpenseProduct::factory(10)->create();


        Branch::factory(10)->create();

        Customer::factory(10)->create();
        Supplier::factory(10)->create();
        ExpensePeople::factory(10)->create();
        LoanPeople::factory(10)->create();
        Owner::factory(10)->create();

        Expense::factory(10)->create();
        BillablePayment::factory(10)->create();
        BillableExpense::factory(10)->create();
        BillableProduct::factory(10)->create();
        // PaymentSent::factory(10)->create();
        // PaymentReceived::factory(10)->create();

        Consume::factory(10)->create();
        ConsumeDetails::factory(10)->create();

        Produce::factory(10)->create();
        ProduceDetails::factory(10)->create();

        WarehouseProduct::factory(10)->create();
        WarehouseMaterial::factory(10)->create();


        Purchase::factory(10)->create();
        PurchaseDetail::factory(10)->create();
        PurchaseExpense::factory(10)->create();
        PurchasePayment::factory(10)->create();
        
        
        Sale::factory(10)->create();
        SaleDetails::factory(10)->create();
        SaleExpense::factory(10)->create();
        SalePayment::factory(10)->create();

        ExpensePaymentSent::factory(10)->create();
        ExpensePaymentReceived::factory(10)->create();
        LoanPaymentSent::factory(10)->create();
        LoanPaymentReceived::factory(10)->create();
        OwnerPaymentSent::factory(10)->create();
        OwnerPaymentReceived::factory(10)->create();
    }
}
