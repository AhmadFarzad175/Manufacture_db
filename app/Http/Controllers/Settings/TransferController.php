<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Models\Settings\Transfer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Settings\WarehouseProduct;
use App\Models\Settings\WarehouseMaterial;
use App\Http\Requests\Settings\TransferRequest;
use App\Http\Resources\Settings\TransferResource;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $transfers = Transfer::with(['fromWarehouse', 'transferDetails'])->search($search);

        $transfers = $transfers->latest()->paginate($perPage);

        return TransferResource::collection($transfers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransferRequest $request)
    {
        // DB::beginTransaction();

        // try {
        // return $request;
        $validated = $request->validated();
        $transfer = Transfer::create($validated);

        //INSERT INTO PIVOT TABLE
        foreach ($validated['transferDetails'] as $transferDetail) {
            Transfer::create([
                'transfer_id' => $transfer->id,
                'productMaterial_id' => $transferDetail['productMaterialId'],
                'type' => $transferDetail['type'],
                'quantity' => $transferDetail['quantity'],
                'unit_cost' => $transferDetail['unitCost'],
            ]);

            
            // Update existing record
            if ($transferDetail['type'] == 0) {
                //UPDATE THE WAREHOUSE PRODUCT TABLE
                $warehouseProduct = WarehouseMaterial::where('warehouse_id', $validated['from_warehouse_id '])
                    ->where('material_id', $transferDetail['productMaterial_id'])
                    ->first();
    
                $warehouseProduct = WarehouseMaterial::where('warehouse_id', $validated['from_warehouse_id '])
                    ->where('material_id', $transferDetail['productMaterial_id'])
                    ->first();
                if ($warehouseProduct && $warehouseProduct->quantity >= $transferDetail['quantity']) {
                    $warehouseProduct->decrement('quantity', $transferDetail['quantity']);
                }
            }

            //UPDATE THE WAREHOUSE PRODUCT TABLE
            if ($transferDetail['type'] == 1) {
                $warehouseProduct = WarehouseProduct::where('warehouse_id', $validated['from_warehouse_id '])
                    ->where('product_id', $transferDetail['productMaterial_id'])
                    ->first();
    
                $warehouseProduct = WarehouseProduct::where('warehouse_id', $validated['from_warehouse_id '])
                    ->where('product_id', $transferDetail['productMaterial_id'])
                    ->first();

                if ($warehouseProduct && $warehouseProduct->quantity >= $transferDetail['quantity']) {
                    $warehouseProduct->decrement('quantity', $transferDetail['quantity']);
                }
            }

            $warehouseProduct = WarehouseProduct::where('warehouse_id', $validated['warehouse_id'])
                ->where('product_id', $transferDetail['product_id'])
                ->first();

            if ($warehouseProduct && $warehouseProduct->quantity >= $transferDetail['quantity']) {
                // Update existing record
                $warehouseProduct->decrement('quantity', $transferDetail['quantity']);
            }
        }
       


        DB::commit();
        return TransferResource::make($transfer);
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     // Handle the exception, log it, or return an error response
        //     return response()->json(['message' => 'An error occurred while processing the request.'], 500);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transfer $transfer)
    {
        return TransferResource::make($transfer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transfer $transfer)
    {
        $transfer->update($request->validated());

        // Update transfer details if necessary
        if ($request->has('transferDetails')) {

            
            foreach ($request->input('transferDetails') as $transferDetail) {
                
            }

        }

        return TransferResource::make($transfer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transfer)
    {
        $transfer->delete();
    }
}
