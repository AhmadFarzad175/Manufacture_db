<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Models\Settings\Account;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Finances\OwnerPaymentReceived;
use App\Http\Requests\Finances\OwnerPaymentReceivedRequest;
use App\Http\Resources\Finances\OwnerPaymentReceivedResource;



class OwnerPaymentReceivedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $ownerPaymentReceiveds = OwnerPaymentReceived::with(['account', 'owner', 'user'])->search($search);

        $ownerPaymentReceiveds = $ownerPaymentReceiveds->latest()->paginate($perPage);

        return OwnerPaymentReceivedResource::collection($ownerPaymentReceiveds);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OwnerPaymentReceivedRequest $request)
    {
        $validated = $request->validated();

        // DB::beginTransaction();

        // try {
        $account = Account::firstWhere('id', $validated['account_id']);

        //CHECK IF THE ACCOUNT HAS ENOUGH BALANCE AND Decrease THE ACCOUNT
        if ($account->price >= $validated['amount']) {

            $account->decrement('price', $validated['amount']);

            $payment = OwnerPaymentReceived::create($validated);

            DB::commit();

            return OwnerPaymentReceivedResource::make($payment);
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
    public function show(OwnerPaymentReceived $ownerPaymentReceived)
    {
        return OwnerPaymentReceivedResource::make($ownerPaymentReceived);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OwnerPaymentReceivedRequest $request, OwnerPaymentReceived $ownerPaymentReceived)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $account = Account::firstWhere('id', $validated['account_id']);

            $oldAmount = $ownerPaymentReceived->amount;
            $difference = $validated['amount'] - $oldAmount;


            if ($difference > 0 && $account->price < $difference) {
                DB::rollback();
                return response()->json(['message' => 'Insufficient balance.'], 403);
            }
            // Check if the account has enough balance to update

            // Increment the old amount back to the account balance
            $account->decrement('price', $difference);

            // Update the purchase purchase$purchasePayment record
            $ownerPaymentReceived->update($validated);


            DB::commit();

            return OwnerPaymentReceivedResource::make($ownerPaymentReceived);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Transaction failed.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OwnerPaymentReceived $ownerPaymentReceived)
    {
        $amount =  $ownerPaymentReceived->amount;
        $account = Account::firstWhere('id', $ownerPaymentReceived->account_id);
        $account->increment('price', $amount);

        $ownerPaymentReceived->delete();
        return response()->noContent();
    }



    public function bulkDelete(Request $request)
    {
        $ownerPaymentReceiveds = $request->input('paymentSentIds');

        // Group the payments by account currency and sum the prices
        $totalAmounts = OwnerPaymentReceived::whereIn('id', $ownerPaymentReceiveds)
            ->select('account_id', DB::raw('SUM(price) as total_price'))
            ->groupBy('account_id')
            ->get();

        // Increment each corresponding account's price with the sum
        foreach ($totalAmounts as $totalAmount) {
            $account = Account::findOrFail($totalAmount->account_id);
            $account->increment('price', $totalAmount->total_price);
        }


        OwnerPaymentReceived::destroy($ownerPaymentReceiveds);
    }
}
