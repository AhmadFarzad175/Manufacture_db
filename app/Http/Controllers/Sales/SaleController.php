<?php

namespace App\Http\Controllers\Sales;

use App\Models\Sales\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Sales\SaleResource;
use App\Models\Settings\WarehouseProduct;

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
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
        $validated = $request->validated();
        $sale = Sale::create($validated);

        foreach ($request->input('saleDetails') as $saleDetail) {
            $saleDetail['product_id'] = $saleDetail['materialId'];
            $saleDetail['unit_cost'] = $saleDetail['unitCost'];

            $sale->products()->attach($saleDetail['product_id'], [
                'quantity' => $saleDetail['quantity'],
                'unit_cost' => $saleDetail['unit_cost'],
            ]);

            $warehouseProduct = WarehouseProduct::where('warehouse_id', $request->input('warehouse_id'))
                ->where('product_id', $saleDetail['product_id'])
                ->first();

            if ($warehouseProduct) {
                // Update existing record
                $warehouseProduct->quantity += $saleDetail['quantity'];
                $warehouseProduct->save();
            } else {
                // Create new record
                WarehouseProduct::create([
                    'warehouse_id' => $request->input('warehouse_id'),
                    'product_id' => $saleDetail['product_id'],
                    'quantity' => $saleDetail['quantity'],
                ]);
            }
        }

        DB::commit();
        return SaleResource::make($sale);
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the exception, log it, or return an error response
            return response()->json(['message' => 'An error occurred while processing the request.'], 500);
        }
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
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
