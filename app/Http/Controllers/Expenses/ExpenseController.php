<?php

namespace App\Http\Controllers\Expenses;

use Illuminate\Http\Request;
use App\Models\Expenses\Expense;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Expenses\ExpenseRequest;
use App\Http\Resources\Expenses\ExpenseResource;




class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $expenses = Expense::with(['expenseCategory', 'user', 'expensePeople'])
            ->search($search);

        $expenses = $perPage ? $expenses->latest()->paginate($perPage) : $expenses->latest()->get();

        return ExpenseResource::collection($expenses);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id() ?? 1;
        $expense = Expense::create($validated);
        return ExpenseResource::make($expense);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        return ExpenseResource::make($expense);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseRequest $request, Expense $expense)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id() ?? 2;
        $expense->update($validated);
        return ExpenseResource::make($expense);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return response()->noContent();
    }

    public function bulkDelete(Request $request)
    {
        $expenses = $request->input('expenseIds');
        Expense::destroy($expenses);
    }
}
