<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use App\Models\Settings\Account;
use App\Models\Sales\SaleExpense;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sales\SaleExpenseRequest;
use App\Http\Resources\Sales\SaleExpenseResource;


class SaleExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');
        $sale = $request->input('sale');


        // Eager load relationships and apply search
        $saleExpenses = SaleExpense::with(['user'])->search($search, $sale);

        $saleExpenses = $perPage ? $saleExpenses->latest()->paginate($perPage) : $saleExpenses->latest()->get();

        return SaleExpenseResource::collection($saleExpenses);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaleExpenseRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $account = Account::findOrFail($validated['account_id']);

            //CHECK IF THE ACCOUNT HAS ENOUGH BALANCE AND Decrease THE ACCOUNT
            if ($account->price >= $validated['amount']) {

                $account->decrement('price', $validated['amount']);

                $expense = SaleExpense::create($validated);

                DB::commit();

                return SaleExpenseResource::make($expense);
            } else {
                return response()->json(['message' => 'Insufficient balance.'], 403);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Transaction failed.'], 500);
        }

    }


    /**
     * Display the specified resource.
     */
    public function show(SaleExpense $saleEpense)
    {
        return SaleExpenseResource::make($saleEpense);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaleExpenseRequest $request, SaleExpense $saleExpense)
{
    $validated = $request->validated();

    DB::beginTransaction();

    try {
        $oldAmount = $saleExpense->amount;

        $account = Account::findOrFail($validated['account_id']);

        $difference = $validated['amount'] - $oldAmount;

        if ($difference > 0 && $account->price < $difference) {
            DB::rollback();
            return response()->json(['message' => 'Insufficient balance.'], 403);
        }

        $account->decrement('price', $difference);

        $saleExpense->update($validated);

        DB::commit();

        return SaleExpenseResource::make($saleExpense);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['message' => 'Transaction failed.'], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleExpense $saleExpense)
    {
        $saleExpense->delete();
        return response()->noContent();
    }

    public function bulkDelete(Request $request)
    {
        $saleExpenses = $request->input('expenseIds');
        SaleExpense::destroy($saleExpenses);
    }
}
