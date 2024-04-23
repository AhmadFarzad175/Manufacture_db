<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Settings\Warehouse;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AllController;
use App\Http\Controllers\Sales\SaleController;
use App\Http\Controllers\PaymentSentController;
use App\Http\Controllers\Peoples\UserController;
use App\Http\Controllers\Settings\UnitController;
use App\Http\Controllers\PaymentReceivedController;
use App\Http\Controllers\Expenses\ExpenseController;
use App\Http\Controllers\Peoples\CustomerController;
use App\Http\Controllers\peoples\SupplierController;
use App\Http\Controllers\Settings\AccountController;
use App\Http\Controllers\Settings\ProductController;
use App\Http\Controllers\Sales\SaleExpenseController;
use App\Http\Controllers\Sales\SalePaymentController;
use App\Http\Controllers\Settings\CurrencyController;
use App\Http\Controllers\Settings\MaterialController;
use App\Http\Controllers\Purchases\PurchaseController;
use App\Http\Controllers\Settings\WarehouseController;
use App\Http\Controllers\Peoples\ExpensePeopleController;
use App\Http\Controllers\Settings\SystemSettingController;
use App\Http\Controllers\Expenses\ExpensePaymentController;
use App\Http\Controllers\Settings\ExpenseProductController;
use App\Http\Controllers\Expenses\BillableExpenseController;
use App\Http\Controllers\Expenses\BillablePaymentController;
use App\Http\Controllers\Settings\AccountTransferController;
use App\Http\Controllers\Settings\ExpenseCategoryController;
use App\Http\Controllers\Purchases\PurchaseExpenseController;
use App\Http\Controllers\Purchases\PurchasePaymentController;
use App\Http\Controllers\Settings\MaterialCategoryController;
use App\Http\Controllers\ProductManagements\ConsumeController;
use App\Http\Controllers\Finances\ExpensePaymentSentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


#SETTINGS
Route::apiResource('/systemSettings', SystemSettingController::class);
Route::post('/systemSettings/update/{systemSetting}', [SystemSettingController::class, 'updateSystem']);

Route::apiResource('/currencies', CurrencyController::class);
Route::post('currenciesBulkDelete', [CurrencyController::class, 'bulkDelete']);
Route::post('curriencyAccount',[AllController::class, 'currencyAccount'] );

Route::apiResource('/warehouses', WarehouseController::class);
Route::post('warehousesBulkDelete', [WarehouseController::class, 'bulkDelete']);

Route::apiResource('/accounts', AccountController::class);
Route::post('accountsBulkDelete', [AccountController::class, 'bulkDelete']);
Route::apiResource('/accountTransfer', AccountTransferController::class);

Route::apiResource('/products', ProductController::class);
Route::post('productsBulkDelete', [ProductController::class, 'bulkDelete']);
Route::post('/products/update/{product}', [ProductController::class, 'updateProduct']);

Route::apiResource('/materials', MaterialController::class);
Route::post('materialsBulkDelete', [MaterialController::class, 'bulkDelete']);
Route::post('/materials/update/{material}', [MaterialController::class, 'updateMaterial']);

Route::apiResource('/materialCategories', MaterialCategoryController::class);
Route::post('materialCategoriesBulkDelete', [MaterialCategoryController::class, 'bulkDelete']);

Route::apiResource('/expenseCategories', ExpenseCategoryController::class);
Route::apiResource('/expenseProducts', ExpenseProductController::class);

Route::apiResource('/units', UnitController::class);
Route::post('unitsBulkDelete', [UnitController::class, 'bulkDelete']);


#PEOPLE
Route::apiResource('/customers', CustomerController::class);
Route::apiResource('/suppliers', SupplierController::class);
Route::apiResource('/expensePeoples', ExpensePeopleController::class);
Route::apiResource('/users', UserController::class);


#EXPENSE
Route::apiResource('/expenses', ExpenseController::class);
Route::apiResource('/billablePayments', BillablePaymentController::class);
Route::apiResource('/billableExpenses', BillableExpenseController::class);
Route::apiResource('/paymentSents', PaymentSentController::class);
Route::apiResource('/paymentReceiveds', PaymentReceivedController::class);


#CONSUME
Route::apiResource('/consumes', ConsumeController::class);


#PURCHASE
Route::apiResource('/purchases', PurchaseController::class);
Route::apiResource('/purchaseExpenses', PurchaseExpenseController::class);
Route::apiResource('/purchasePayments', PurchasePaymentController::class);


#SALES
Route::apiResource('/sales', SaleController::class);
Route::apiResource('/SaleExpenses', SaleExpenseController::class);
Route::apiResource('/SalePayments', SalePaymentController::class);


#Finance
Route::apiResource('/expensePaymentSents', ExpensePaymentSentController::class);

