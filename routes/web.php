<?php

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// GETTING THE RELATIONAL DATA IN TABLES:
Route::get('/expenseCat/{expenseCategory}', function (ExpenseCategory $expenseCategory) {
    return view(
        'welcome',
        [
            'expense' => $expenseCategory->expenses->load(['expenseCategory'])

        ]
    );
});

Route::get('/', function () {

    return view('welcome');
    
});
