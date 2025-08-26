<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Models\Settings\Account;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Finances\OwnerPaymentSent;
use App\Http\Requests\Finances\OwnerPaymentSentRequest;
use App\Http\Resources\Finances\OwnerPaymentSentResource;


class OwnerPaymentSentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $OwnerPaymentSents = OwnerPaymentSent::with(['account', 'owner', 'user'])->search($search);

        $OwnerPaymentSents = $OwnerPaymentSents->latest()->paginate($perPage);

        return OwnerPaymentSentResource::collection($OwnerPaymentSents);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OwnerPaymentSentRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id() ?? 1;


        // DB::beginTransaction();

        // try {
        $account = Account::firstWhere('id', $validated['account_id']);

        //CHECK IF THE ACCOUNT HAS ENOUGH BALANCE AND Decrease THE ACCOUNT
        if ($account->price >= $validated['amount']) {

            $account->decrement('price', $validated['amount']);

            $payment = OwnerPaymentSent::create($validated);

            DB::commit();

            return OwnerPaymentSentResource::make($payment);
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
    public function show(OwnerPaymentSent $ownerPaymentSent)
    {
        return OwnerPaymentSentResource::make($ownerPaymentSent);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OwnerPaymentSentRequest $request, OwnerPaymentSent $ownerPaymentSent)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id() ?? 1;


        DB::beginTransaction();

        try {
            $account = Account::firstWhere('id', $validated['account_id']);

            $oldAmount = $ownerPaymentSent->amount;
            $difference = $validated['amount'] - $oldAmount;


            if ($difference > 0 && $account->price < $difference) {
                DB::rollback();
                return response()->json(['message' => 'Insufficient balance.'], 403);
            }
            // Check if the account has enough balance to update

            // Increment the old amount back to the account balance
            $account->decrement('price', $difference);

            // Update the purchase purchase$purchasePayment record
            $ownerPaymentSent->update($validated);


            DB::commit();

            return OwnerPaymentSentResource::make($ownerPaymentSent);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Transaction failed.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OwnerPaymentSent $ownerPaymentSent)
    {
        $amount =  $ownerPaymentSent->amount;
        $account = Account::firstWhere('id', $ownerPaymentSent->account_id);
        $account->increment('price', $amount);

        $ownerPaymentSent->delete();
        return response()->noContent();
    }


    public function bulkDelete(Request $request)
    {
        $ownerPaymentSents = $request->input('paymentSentIds');

        // Group the payments by account currency and sum the prices
        $totalAmounts = OwnerPaymentSent::whereIn('id', $ownerPaymentSents)
            ->select('account_id', DB::raw('SUM(price) as total_price'))
            ->groupBy('account_id')
            ->get();

        // Increment each corresponding account's price with the sum
        foreach ($totalAmounts as $totalAmount) {
            $account = Account::findOrFail($totalAmount->account_id);
            $account->increment('price', $totalAmount->total_price);
        }


        OwnerPaymentSent::destroy($ownerPaymentSents);
    }
}
