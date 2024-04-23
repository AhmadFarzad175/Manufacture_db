<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Models\Settings\Account;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Finances\ExpensePaymentSent;
use App\Http\Resources\Purchases\SalePaymentResource;
use App\Http\Requests\Finances\ExpensePaymentSentRequest;
use App\Http\Resources\Finances\ExpensePaymentSentResource;

class ExpensePaymentSentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $ExpensePaymentSents = ExpensePaymentSent::with(['account', 'expensePeople', 'user'])->search($search);

        $ExpensePaymentSents = $ExpensePaymentSents->latest()->paginate($perPage);

        return ExpensePaymentSentResource::collection($ExpensePaymentSents);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpensePaymentSentRequest $request)
    {
        $validated = $request->validated();

        // DB::beginTransaction();

        // try {
        $account = Account::firstWhere('id', $validated['account_id']);

        //CHECK IF THE ACCOUNT HAS ENOUGH BALANCE AND Decrease THE ACCOUNT
        if ($account->price >= $validated['amount']) {

            $account->decrement('price', $validated['amount']);

            $payment = ExpensePaymentSent::create($validated);

            DB::commit();

            return ExpensePaymentSentResource::make($payment);
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
    public function show(ExpensePaymentSent $expensePaymentSent)
    {
        return ExpensePaymentSentResource::make($expensePaymentSent);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpensePaymentSentRequest $request, ExpensePaymentSent $expensePaymentSent)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $account = Account::firstWhere('id', $validated['account_id']);

            $oldAmount = $expensePaymentSent->amount;
            $difference = $validated['amount'] - $oldAmount;


            if ($difference > 0 && $account->price < $difference) {
                DB::rollback();
                return response()->json(['message' => 'Insufficient balance.'], 403);
            }
            // Check if the account has enough balance to update

            // Increment the old amount back to the account balance
            $account->decrement('price', $difference);

            // Update the purchase purchase$purchasePayment record
            $expensePaymentSent->update($validated);


            DB::commit();

            return ExpensePaymentSentResource::make($expensePaymentSent);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Transaction failed.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpensePaymentSent $expensePaymentSent)
    {
        $amount =  $expensePaymentSent->amount;
        $account = Account::firstWhere('id', $expensePaymentSent->account_id);
        $account->increment('price', $amount);

        $expensePaymentSent->delete();
        return response()->noContent();
    }


    public function bulkDelete(Request $request)
    {
        $expensePaymentSents = $request->input('paymentSentIds');

        // Group the payments by account currency and sum the prices
        $totalAmounts = ExpensePaymentSent::whereIn('id', $expensePaymentSents)
            ->select('account_id', DB::raw('SUM(price) as total_price'))
            ->groupBy('account_id')
            ->get();

        // Increment each corresponding account's price with the sum
        foreach ($totalAmounts as $totalAmount) {
            $account = Account::findOrFail($totalAmount->account_id);
            $account->increment('price', $totalAmount->total_price);
        }


        ExpensePaymentSent::destroy($expensePaymentSents);
    }
}
