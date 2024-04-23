<?php

namespace App\Http\Controllers\Sales;

use App\Models\Sales\Sale;
use Illuminate\Http\Request;
use App\Models\Settings\Account;
use App\Models\Sales\SalePayment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Purchases\SalePaymentRequest;
use App\Http\Resources\Purchases\SalePaymentResource;


class SalePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $salePayments = SalePayment::with(['account', 'user'])->search($search);

        $salePayments = $salePayments->latest()->paginate($perPage);

        return SalePaymentResource::collection($salePayments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalePaymentRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $account = Account::findOrFail($validated['account_id']);

            //CHECK IF THE ACCOUNT HAS ENOUGH BALANCE AND Decrease THE ACCOUNT
            if ($account->price >= $validated['amount']) {

                $account->decrement('price', $validated['amount']);

                $payment = SalePayment::create($validated);

                // Update the paid column of the sale
                $sale = Sale::findOrFail($validated['sale_id']);
                $sale->increment('paid', $validated['amount']);

                DB::commit();

                return SalePaymentResource::make($payment);
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
    public function show(SalePayment $salePayment)
    {
        return SalePaymentResource::make($salePayment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalePaymentRequest $request, SalePayment $salePayment)
{
    $validated = $request->validated();

    DB::beginTransaction();

    try {
        
        $account = Account::findOrFail($validated['account_id']);
        $sale = Sale::findOrFail($validated['sale_id']);

        $oldAmount = $salePayment->amount;
        $difference = $validated['amount'] - $oldAmount;


        if ($difference > 0 && $account->price < $difference) {
            DB::rollback();
            return response()->json(['message' => 'Insufficient balance.'], 403);
        }
        // Check if the account has enough balance to update

            // Increment the old amount back to the account balance
            $account->decrement('price', $difference);

            $sale->increment('paid', $difference);


            // Update the sale sale$salePayment record
            $salePayment->update($validated);
            

            DB::commit();

            return SalePaymentResource::make($salePayment);
       
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['message' => 'Transaction failed.'], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalePayment $salePayment)
    {
        $salePayment->delete();
        return response()->noContent();
    }

    public function bulkDelete(Request $request)
    {
        $salePayments = $request->input('paymentIds');
        SalePayment::destroy($salePayments);
    }
}
