<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Http\Resources\ExpenseResource;
use App\Http\Requests\ExpenseCategoryRequest;
use App\Http\Requests\StoreExpenseCategoryRequest;
use App\Http\Requests\UpdateExpenseCategoryRequest;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ExpenseResource(ExpenseCategory::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseCategoryRequest $request)
    {
        $validated = $request->validated();
        ExpenseCategory::create($validated);
        return 'Category inserted successfully';
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseCategory $expenseCategory)
    {
        return new ExpenseResource($expenseCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseCategoryRequest $request, ExpenseCategory $expenseCategory)
    {
        $validated = $request->validated();
        $expenseCategory->update($validated);
        return $expenseCategory;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();
        return 'category deleted successfully';
    }
}
