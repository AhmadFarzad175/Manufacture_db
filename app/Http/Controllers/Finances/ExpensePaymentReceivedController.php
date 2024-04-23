<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Models\Settings\Account;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Finances\ExpensePaymentReceived;
use App\Http\Requests\Finances\ExpensePaymentReceivedRequest;
use App\Http\Resources\Finances\ExpensePaymentReceivedResource;

class ExpensePaymentReceivedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $ExpensePaymentReceiveds = ExpensePaymentReceived::with(['account', 'expensePeople', 'user'])->search($search);

        $ExpensePaymentReceiveds = $ExpensePaymentReceiveds->latest()->paginate($perPage);

        return ExpensePaymentReceivedResource::collection($ExpensePaymentReceiveds);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpensePaymentReceivedRequest $request)
    {
        $validated = $request->validated();

        // DB::beginTransaction();

        // try {
        $account = Account::firstWhere('id', $validated['account_id']);

        //CHECK IF THE ACCOUNT HAS ENOUGH BALANCE AND Decrease THE ACCOUNT
        if ($account->price >= $validated['amount']) {

            $account->decrement('price', $validated['amount']);

            $payment = ExpensePaymentReceived::create($validated);

            DB::commit();

            return ExpensePaymentReceivedResource::make($payment);
        } else {
            return response()->json(['message' => 'Insufficient balance.'], 403);
        }
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     return response()->json(['message' => 'Transaction failed.'], 500);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpensePaymentReceived $expensePaymentReceived)
    {
        return ExpensePaymentReceivedResource::make($expensePaymentReceived);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpensePaymentReceivedRequest $request, ExpensePaymentReceived $expensePaymentReceived)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $account = Account::firstWhere('id', $validated['account_id']);

            $oldAmount = $expensePaymentReceived->amount;
            $difference = $validated['amount'] - $oldAmount;


            if ($difference > 0 && $account->price < $difference) {
                DB::rollback();
                return response()->json(['message' => 'Insufficient balance.'], 403);
            }
            // Check if the account has enough balance to update

            // Increment the old amount back to the account balance
            $account->decrement('price', $difference);

            // Update the purchase purchase$purchasePayment record
            $expensePaymentReceived->update($validated);


            DB::commit();

            return ExpensePaymentReceivedResource::make($expensePaymentReceived);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Transaction failed.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpensePaymentReceived $expensePaymentReceived)
    {
        $amount =  $expensePaymentReceived->amount;
        $account = Account::firstWhere('id', $expensePaymentReceived->account_id);
        $account->increment('price', $amount);

        $expensePaymentReceived->delete();
        return response()->noContent();
    }



    public function bulkDelete(Request $request)
    {
        $expensePaymentReceiveds = $request->input('paymentSentIds');

        // Group the payments by account currency and sum the prices
        $totalAmounts = ExpensePaymentReceived::whereIn('id', $expensePaymentReceiveds)
            ->select('account_id', DB::raw('SUM(price) as total_price'))
            ->groupBy('account_id')
            ->get();

        // Increment each corresponding account's price with the sum
        foreach ($totalAmounts as $totalAmount) {
            $account = Account::findOrFail($totalAmount->account_id);
            $account->increment('price', $totalAmount->total_price);
        }


        ExpensePaymentReceived::destroy($expensePaymentReceiveds);
    }
}
