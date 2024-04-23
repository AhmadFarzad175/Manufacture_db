<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Models\Settings\Account;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Finances\LoanPaymentSent;
use App\Http\Requests\Finances\LoanPaymentSentRequest;
use App\Http\Resources\Finances\LoanPaymentSentResource;


class LoanPaymentSentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $LoanPaymentSents = LoanPaymentSent::with(['account', 'loanPeople', 'user'])->search($search);

        $LoanPaymentSents = $LoanPaymentSents->latest()->paginate($perPage);

        return LoanPaymentSentResource::collection($LoanPaymentSents);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoanPaymentSentRequest $request)
    {
        $validated = $request->validated();

        // DB::beginTransaction();

        // try {
        $account = Account::firstWhere('id', $validated['account_id']);

        //CHECK IF THE ACCOUNT HAS ENOUGH BALANCE AND Decrease THE ACCOUNT
        if ($account->price >= $validated['amount']) {

            $account->decrement('price', $validated['amount']);

            $payment = LoanPaymentSent::create($validated);

            DB::commit();

            return LoanPaymentSentResource::make($payment);
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
    public function show(LoanPaymentSent $loanPaymentSent)
    {
        return LoanPaymentSentResource::make($loanPaymentSent);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LoanPaymentSentRequest $request, LoanPaymentSent $loanPaymentSent)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $account = Account::firstWhere('id', $validated['account_id']);

            $oldAmount = $loanPaymentSent->amount;
            $difference = $validated['amount'] - $oldAmount;


            if ($difference > 0 && $account->price < $difference) {
                DB::rollback();
                return response()->json(['message' => 'Insufficient balance.'], 403);
            }
            // Check if the account has enough balance to update

            // Increment the old amount back to the account balance
            $account->decrement('price', $difference);

            // Update the purchase purchase$purchasePayment record
            $loanPaymentSent->update($validated);


            DB::commit();

            return LoanPaymentSentResource::make($loanPaymentSent);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Transaction failed.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoanPaymentSent $loanPaymentSent)
    {
        $amount =  $loanPaymentSent->amount;
        $account = Account::firstWhere('id', $loanPaymentSent->account_id);
        $account->increment('price', $amount);

        $loanPaymentSent->delete();
        return response()->noContent();
    }


    public function bulkDelete(Request $request)
    {
        $loanPaymentSents = $request->input('paymentSentIds');

        // Group the payments by account currency and sum the prices
        $totalAmounts = LoanPaymentSent::whereIn('id', $loanPaymentSents)
            ->select('account_id', DB::raw('SUM(price) as total_price'))
            ->groupBy('account_id')
            ->get();

        // Increment each corresponding account's price with the sum
        foreach ($totalAmounts as $totalAmount) {
            $account = Account::findOrFail($totalAmount->account_id);
            $account->increment('price', $totalAmount->total_price);
        }


        LoanPaymentSent::destroy($loanPaymentSents);
    }
}
