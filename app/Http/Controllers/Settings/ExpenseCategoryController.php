<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ExpenseCategoryRequest;
use App\Models\Settings\ExpenseCategory;
use App\Http\Resources\Settings\ExpenseCategoryResource;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $expenseCategories = ExpenseCategory::query()->search($search);

        $expenseCategories = $perPage ? $expenseCategories->latest()->paginate($perPage) : $expenseCategories->latest()->get();

        return ExpenseCategoryResource::collection($expenseCategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseCategoryRequest $request)
    {
        $expenseCategory = ExpenseCategory::create($request->validated());
        return ExpenseCategoryResource::make($expenseCategory);
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseCategory $expenseCategory)
    {
        return ExpenseCategoryResource::make($expenseCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseCategoryRequest $request, ExpenseCategory $expenseCategory)
    {
        $expenseCategory->update($request->validated());
        return ExpenseCategoryResource::make($expenseCategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();
        return response()->noContent();
    }

    public function bulkDelete(Request $request)
    {
        $epxenseCategories = $request->input('expenseCategoryIds');
        ExpenseCategory::destroy($epxenseCategories);
    }
}
