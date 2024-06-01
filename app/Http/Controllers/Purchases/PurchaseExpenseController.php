<?php

namespace App\Http\Controllers\Purchases;

use Illuminate\Http\Request;
use App\Models\Settings\Account;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchases\PurchaseExpense;
use App\Http\Requests\Purchases\PurchaseExpenseRequest;
use App\Http\Resources\Purchases\PurchaseExpenseResource;

class PurchaseExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $purchaseExpenses = PurchaseExpense::with(['account', 'expenseCategory', 'user'])->search($search);

        $purchaseExpenses = $perPage ? $purchaseExpenses->latest()->paginate($perPage) : $purchaseExpenses->latest()->get();

        return PurchaseExpenseResource::collection($purchaseExpenses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PurchaseExpenseRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id() ?? 1;


        DB::beginTransaction();

        try {
            $account = Account::findOrFail($validated['account_id']);

            //CHECK IF THE ACCOUNT HAS ENOUGH BALANCE AND Decrease THE ACCOUNT
            if ($account->price >= $validated['amount']) {

                $account->decrement('price', $validated['amount']);

                $expense = PurchaseExpense::create($validated);

                DB::commit();

                return PurchaseExpenseResource::make($expense);
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
    public function show(PurchaseExpense $purchaseExpense)
    {
        return PurchaseExpenseResource::make($purchaseExpense);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PurchaseExpenseRequest $request, PurchaseExpense $purchaseExpense)
{
    $validated = $request->validated();

    DB::beginTransaction();

    try {
        $oldAmount = $purchaseExpense->amount;

        $account = Account::findOrFail($validated['account_id']);

        $difference = $validated['amount'] - $oldAmount;

        if ($difference > 0 && $account->price < $difference) {
            DB::rollback();
            return response()->json(['message' => 'Insufficient balance.'], 403);
        }

        $account->decrement('price', $difference);

        $purchaseExpense->update($validated);

        DB::commit();

        return PurchaseExpenseResource::make($purchaseExpense);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['message' => 'Transaction failed.'], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseExpense $purchaseExpense)
    {
        $purchaseExpense->delete();
        return response()->noContent();
    }

    public function bulkDelete(Request $request)
    {
        $purchaseExpenses = $request->input('expenseIds');
        PurchaseExpense::destroy($purchaseExpenses);
    }
}
