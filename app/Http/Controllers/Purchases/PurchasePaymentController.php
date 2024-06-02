<?php

namespace App\Http\Controllers\Purchases;

use Illuminate\Http\Request;
use App\Models\Settings\Account;
use App\Models\Purchases\Purchase;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Purchases\PurchasePayment;
use App\Http\Requests\Purchases\PurchasePaymentRequest;
use App\Http\Resources\Purchases\PurchasePaymentResource;

class PurchasePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');
        $purchase = $request->input('purchase');
        
        // Eager load relationships and apply search
        $purchasePayments = PurchasePayment::with(['account', 'user'])->search($search, $purchase);

        $purchasePayments = $perPage ? $purchasePayments->latest()->paginate($perPage) : $purchasePayments->latest()->get();

        return PurchasePaymentResource::collection($purchasePayments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PurchasePaymentRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $account = Account::findOrFail($validated['account_id']);

            //CHECK IF THE ACCOUNT HAS ENOUGH BALANCE AND Decrease THE ACCOUNT
            if ($account->price >= $validated['amount']) {

                $account->decrement('price', $validated['amount']);

                $payment = PurchasePayment::create($validated);

                // Update the paid column of the purchase
                $purchase = Purchase::findOrFail($validated['purchase_id']);
                $purchase->increment('paid', $validated['amount']);

                DB::commit();

                return PurchasePaymentResource::make($payment);
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
    public function show(PurchasePayment $purchasePayment)
    {
        return PurchasePaymentResource::make($purchasePayment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PurchasePaymentRequest $request, PurchasePayment $purchasePayment)
{
    $validated = $request->validated();

    DB::beginTransaction();

    try {
        
        $account = Account::findOrFail($validated['account_id']);
        $purchase = Purchase::findOrFail($validated['purchase_id']);

        $oldAmount = $purchasePayment->amount;
        $difference = $validated['amount'] - $oldAmount;


        if ($difference > 0 && $account->price < $difference) {
            DB::rollback();
            return response()->json(['message' => 'Insufficient balance.'], 403);
        }
        // Check if the account has enough balance to update

            // Increment the old amount back to the account balance
            $account->decrement('price', $difference);

            $purchase->increment('paid', $difference);


            // Update the purchase purchase$purchasePayment record
            $purchasePayment->update($validated);
            

            DB::commit();

            return PurchasePaymentResource::make($purchasePayment);
       
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['message' => 'Transaction failed.'], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchasePayment $purchasePayment)
    {
        $purchasePayment->delete();
        return response()->noContent();
    }

    public function bulkDelete(Request $request)
    {
        $purchasePayments = $request->input('paymentIds');
        PurchasePayment::destroy($purchasePayments);
    }
}
