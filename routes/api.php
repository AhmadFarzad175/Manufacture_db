<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentSendController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\PaymentReceivedController;

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

#EXPENSE MANU ROUTES
Route::apiResource('/expenseCategories', ExpenseCategoryController::class);
Route::apiResource('/expenses', ExpenseController::class);
Route::apiResource('/parties', PartyController::class);
Route::apiResource('/paymentSends', PaymentSendController::class);
Route::apiResource('/paymentReceiveds', PaymentReceivedController::class);
