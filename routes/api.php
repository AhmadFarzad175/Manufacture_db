<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\Product\MaterialController;
use App\Http\Controllers\PaymentSentController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\PaymentReceivedController;
use App\Http\Controllers\product\MaterialCategoryController;

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

#PRODUCT MENU ROUTES
// Route::apiResource('/materialCategories', MaterialCategoryController::class);
// Route::apiResource('/units', UnitController::class);
Route::apiResource('/materials', MaterialController::class);
// Route::apiResource('/products', ProductController::class);


#EXPENSE MENU ROUTES
Route::apiResource('/expenseCategories', ExpenseCategoryController::class);
Route::apiResource('/expenses', ExpenseController::class);
Route::apiResource('/parties', PartyController::class);
Route::apiResource('/paymentSents', PaymentSentController::class);
Route::apiResource('/paymentReceiveds', PaymentReceivedController::class);



Route::get('/user/{user}', function (User $user) {
    return [
        'post' => $user->expenses
    ];
});
