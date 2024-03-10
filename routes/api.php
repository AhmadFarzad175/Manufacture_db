<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Settings\Warehouse;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentSentController;
use App\Http\Controllers\Settings\UnitController;
use App\Http\Controllers\PaymentReceivedController;
use App\Http\Controllers\Settings\AccountController;
use App\Http\Controllers\Settings\ProductController;
use App\Http\Controllers\Settings\CurrencyController;
use App\Http\Controllers\Settings\MaterialController;
use App\Http\Controllers\Purchases\PurchaseController;
use App\Http\Controllers\Settings\WarehouseController;
use App\Http\Controllers\Settings\SystemSettingController;
use App\Http\Controllers\Settings\ExpenseProductController;
use App\Http\Controllers\Settings\AccountTransferController;
use App\Http\Controllers\Settings\ExpenseCategoryController;
use App\Http\Controllers\Settings\MaterialCategoryController;

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


#SETTINGS MENU ROUTES
Route::apiResource('/systemSettings', SystemSettingController::class);
Route::post('/system/update/{id}', [SystemSettingController::class, 'updateSystem']);

Route::apiResource('/currencies', CurrencyController::class);
Route::post('currenciesBulkDelete', [CurrencyController::class, 'bulkDelete']);

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



#EXPENSE MENU ROUTES
Route::apiResource('/expenses', ExpenseController::class);
Route::apiResource('/parties', PartyController::class);
Route::apiResource('/paymentSents', PaymentSentController::class);
Route::apiResource('/paymentReceiveds', PaymentReceivedController::class);


#PURCHASE MENU ROUTES
Route::apiResource('/purchases', PurchaseController::class);





Route::get('/user/{user}', function (User $user) {
    return [
        'post' => $user->expenses
    ];
});
