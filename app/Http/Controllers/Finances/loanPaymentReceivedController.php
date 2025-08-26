<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Models\Settings\Account;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Finances\LoanPaymentReceived;
use App\Http\Requests\Finances\LoanPaymentReceivedRequest;
use App\Http\Resources\Finances\LoanPaymentReceivedResource;


class LoanPaymentReceivedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $LoanPaymentReceiveds = LoanPaymentReceived::with(['account', 'loanPeople', 'user'])->search($search);

        $LoanPaymentReceiveds = $LoanPaymentReceiveds->latest()->paginate($perPage);

        return LoanPaymentReceivedResource::collection($LoanPaymentReceiveds);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoanPaymentReceivedRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id() ?? 1;


        // DB::beginTransaction();

        // try {
        $account = Account::firstWhere('id', $validated['account_id']);

        //CHECK IF THE ACCOUNT HAS ENOUGH BALANCE AND Decrease THE ACCOUNT
        if ($account->price >= $validated['amount']) {

            $account->decrement('price', $validated['amount']);

            $payment = LoanPaymentReceived::create($validated);

            DB::commit();

            return LoanPaymentReceivedResource::make($payment);
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
    public function show(LoanPaymentReceived $loanPaymentReceived)
    {
        return LoanPaymentReceivedResource::make($loanPaymentReceived);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LoanPaymentReceivedRequest $request, LoanPaymentReceived $loanPaymentReceived)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id() ?? 1;


        DB::beginTransaction();

        try {
            $account = Account::firstWhere('id', $validated['account_id']);

            $oldAmount = $loanPaymentReceived->amount;
            $difference = $validated['amount'] - $oldAmount;


            if ($difference > 0 && $account->price < $difference) {
                DB::rollback();
                return response()->json(['message' => 'Insufficient balance.'], 403);
            }
            // Check if the account has enough balance to update

            // Increment the old amount back to the account balance
            $account->decrement('price', $difference);

            // Update the purchase purchase$purchasePayment record
            $loanPaymentReceived->update($validated);


            DB::commit();

            return LoanPaymentReceivedResource::make($loanPaymentReceived);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Transaction failed.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoanPaymentReceived $loanPaymentReceived)
    {
        $amount =  $loanPaymentReceived->amount;
        $account = Account::firstWhere('id', $loanPaymentReceived->account_id);
        $account->increment('price', $amount);

        $loanPaymentReceived->delete();
        return response()->noContent();
    }



    public function bulkDelete(Request $request)
    {
        $loanPaymentReceiveds = $request->input('paymentSentIds');

        // Group the payments by account currency and sum the prices
        $totalAmounts = LoanPaymentReceived::whereIn('id', $loanPaymentReceiveds)
            ->select('account_id', DB::raw('SUM(price) as total_price'))
            ->groupBy('account_id')
            ->get();

        // Increment each corresponding account's price with the sum
        foreach ($totalAmounts as $totalAmount) {
            $account = Account::findOrFail($totalAmount->account_id);
            $account->increment('price', $totalAmount->total_price);
        }


        LoanPaymentReceived::destroy($loanPaymentReceiveds);
    }
}
