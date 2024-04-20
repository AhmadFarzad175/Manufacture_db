<?php

namespace App\Http\Controllers\Sales;

use App\Models\Sales\Sale;
use Illuminate\Http\Request;
use App\Models\Settings\Account;
use App\Models\Sales\SalePayment;
use App\Models\Purchases\Purchase;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sales\SaleRequest;
use App\Models\Settings\WarehouseProduct;
use App\Http\Resources\Sales\SaleResource;
use App\Models\Sales\SaleDetails;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        // Eager load relationships and apply search
        $sales = Sale::with(['products', 'user', 'currency', 'customer'])->search($search);

        $sales = $sales->latest()->paginate($perPage);

        return SaleResource::collection($sales);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaleRequest $request)
    {
        // DB::beginTransaction();

        // try {
        // return $request;
        $validated = $request->validated();
        $sale = Sale::create($validated);

        //INSERT INTO PIVOT TABLE
        foreach ($request->input('saleDetails') as $saleDetail) {
            $saleDetail['product_id'] = $saleDetail['productId'];
            $saleDetail['unit_cost'] = $saleDetail['unitCost'];

            $sale->products()->attach($saleDetail['product_id'], [
                'quantity' => $saleDetail['quantity'],
                'unit_cost' => $saleDetail['unit_cost'],
            ]);

            //UPDATE THE WAREHOUSE PRODUCT TABLE
            $warehouseProduct = WarehouseProduct::where('warehouse_id', $validated['warehouse_id'])
                ->where('product_id', $saleDetail['product_id'])
                ->first();

            if ($warehouseProduct && $warehouseProduct->quantity >= $saleDetail['quantity']) {
                // Update existing record
                $warehouseProduct->decrement('quantity', $saleDetail['quantity']);
            }
        }
        // MAKE A PAYMENT
        $account = Account::findOrFail($validated['account_id']);
        $account->increment('price', $validated['paid']);

        SalePayment::create([
            'date' => $validated['date'],
            'user_id' => $validated['user_id'],
            'sale_id' => $sale->id,
            'account_id' => $validated['account_id'],
            'amount' => $validated['paid'],
        ]);


        DB::commit();
        return SaleResource::make($sale);
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     // Handle the exception, log it, or return an error response
        //     return response()->json(['message' => 'An error occurred while processing the request.'], 500);
        // }
    }



    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        return SaleResource::make($sale);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaleRequest $request, Sale $sale)
    {
        // DB::beginTransaction();

        // try {
        $validated = $request->validated();
        $oldPrice = $sale->paid;
        $sale->update($validated);

        $sale->products()->detach();

        // Insert new products into the sale
        foreach ($request->input('saleDetails') as $saleDetail) {
            $saleDetail['product_id'] = $saleDetail['productId'];
            $saleDetail['unit_cost'] = $saleDetail['unitCost'];

            $sale->products()->attach($saleDetail['product_id'], [
                'quantity' => $saleDetail['quantity'],
                'unit_cost' => $saleDetail['unit_cost'],
            ]);

            // Update the warehouse product table
            $warehouseProduct = WarehouseProduct::where('warehouse_id', $validated['warehouse_id'])
                ->where('product_id', $saleDetail['product_id'])
                ->first();

            $quantity = SaleDetails::where('sale_id', $sale->id)
                ->where('product_id', $saleDetail['product_id']);
            return $quantity;

            if ($warehouseProduct && $warehouseProduct->quantity >= $saleDetail['quantity']) {
                // Update existing record
                $warehouseProduct->decrement('quantity', $saleDetail['quantity']);
            }
        }

        // Update the account
        $account = Account::findOrFail($validated['account_id']);
        $account->decrement('price', $oldPrice); // Decrement old payment
        $account->increment('price', $validated['paid']); // Increment new payment

        //! it may be an error while we also inserted another payments after initialization
        // Update the sale payment record
        $salePayment = SalePayment::firstWhere('sale_id', $sale->id);
        $salePayment->update([
            'date' => $validated['date'],
            'user_id' => $validated['user_id'],
            'account_id' => $validated['account_id'],
            'amount' => $validated['paid'],
        ]);

        // DB::commit();
        return SaleResource::make($sale);
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     // Handle the exception, log it, or return an error response
        //     return response()->json(['message' => 'An error occurred while processing the request.'], 500);
        // }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
