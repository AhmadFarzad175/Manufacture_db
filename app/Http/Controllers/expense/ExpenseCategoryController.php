<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Http\Resources\ExpenseResource;
use App\Http\Requests\ExpenseCategoryRequest;
use App\Http\Resources\ExpenseCategoryResource;


class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');
        $expCats = ExpenseCategory::query()->search($search);
        $expCats = $perPage ? $expCats->latest()->paginate($perPage) : $expCats->latest()->get();
        return ExpenseCategoryResource::collection($expCats);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseCategoryRequest $request)
    {
        $expCat = ExpenseCategory::create($request->validated());
        return ExpenseCategoryResource::make($expCat);
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
        $expCats = $request->input('expenseIds');
        ExpenseCategory::destroy($expCats);
    }
}
