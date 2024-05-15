<?php

namespace App\Http\Controllers\Expenses;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Expenses\BillableExpense;
use App\Http\Requests\Expenses\BillableExpenseRequest;
use App\Http\Resources\Expenses\BillableExpenseResource;

class BillableExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $billExpenses = BillableExpense::with(['expensePeople', 'user', 'currency', 'supplier'])->search($search);

        $billExpenses = $perPage ? $billExpenses->latest()->paginate($perPage) : $billExpenses->latest()->get();

        return BillableExpenseResource::collection($billExpenses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BillableExpenseRequest $request)
    { 
            $validated = $request->validated();
            $validated['user_id'] = Auth::id() ?? 1;
            $billExpense = BillableExpense::create($validated);

            foreach ($request->input('expenseDetails') as $expenseDetail) {
                $billExpense->expenseProduct()->attach($expenseDetail['expense_product_id'], [
                    'quantity' => $expenseDetail['quantity'],
                    'price' => $expenseDetail['price'],
                ]);
            }
            return BillableExpenseResource::make($billExpense);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(BillableExpense $billableExpense)
    {
        return BillableExpenseResource::make($billableExpense);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BillableExpenseRequest $request, BillableExpense $billableExpense)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id() ?? 1;
        $billableExpense->update($validated);

        // Update purchase details if necessary
        if ($request->has('expenseDetails')) {

            $syncData = [];
            foreach ($request->input('expenseDetails') as $expenseDetail) {
                $syncData[$expenseDetail['expense_product_id']] = [
                    'quantity' => $expenseDetail['quantity'],
                    'price' => $expenseDetail['price'],
                ];
            }

            $billableExpense->expenseProduct()->sync($syncData);
        }

        return BillableExpenseResource::make($billableExpense);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BillableExpense $billableExpense)
    {
        // Detach related records from the pivot table
        $billableExpense->expenseProduct()->detach();

        // Delete the BillableExpense record
        $billableExpense->delete();

        return response()->json(['message' => 'BillableExpense deleted successfully']);
    }


    public function bulkDelete(Request $request)
    {
        $billableExpenseIds = $request->input('billableExpenseIds');

        // Detach related records and delete multiple BillableExpense records
        BillableExpense::whereIn('id', $billableExpenseIds)->get()->each(function ($billableExpense) {
            $billableExpense->expenseProduct()->detach();
            $billableExpense->delete();
        });

        return response()->json(['message' => 'BillableExpense records deleted successfully']);
    }
}
