<?php

namespace App\Http\Controllers\Purchases;

use Illuminate\Http\Request;
use App\Models\Purchases\Purchase;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\WarehouseMaterial;
use App\Http\Requests\Purchases\PurchaseRequest;
use App\Http\Resources\Purchases\PurchaseResource;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $purchases = Purchase::with(['warehouse','shipments', 'materials', 'user', 'currency', 'supplier'])->search($search);

        $purchases = $perPage ? $purchases->latest()->paginate($perPage) : $purchases->latest()->get();

        return PurchaseResource::collection($purchases);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PurchaseRequest $request)
    {
        $validated = $request->validated();
        
        // DB::beginTransaction();
        // try {
        $validated['user_id'] = Auth::id() ?? 1;
        $purchase = Purchase::create($validated);
        foreach ($request->input('purchaseDetails') as $purchaseDetail) {
            $purchaseDetail['material_id'] = $purchaseDetail['id'];
            $purchaseDetail['unit_cost'] = $purchaseDetail['unitCost'];
            // dd($purchaseDetail);

            $purchase->materials()->attach($purchaseDetail['material_id'], [
                'quantity' => $purchaseDetail['quantity'],
                'unit_cost' => $purchaseDetail['unit_cost'],
            ]);

            $warehouseMaterial = WarehouseMaterial::where('warehouse_id', $request->input('warehouse_id'))
                ->where('material_id', $purchaseDetail['material_id'])
                ->first();

            if ($warehouseMaterial) {
                // Update existing record
                $warehouseMaterial->quantity += $purchaseDetail['quantity'];
                $warehouseMaterial->save();
            } else {
                // Create new record
                WarehouseMaterial::create([
                    'warehouse_id' => $request->input('warehouse_id'),
                    'material_id' => $purchaseDetail['material_id'],
                    'quantity' => $purchaseDetail['quantity'],
                ]);
            }
        }

        DB::commit();
        return PurchaseResource::make($purchase);
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     // Handle the exception, log it, or return an error response
        //     return response()->json(['message' => 'An error occurred while processing the request.'], 500);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        return PurchaseResource::make($purchase);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PurchaseRequest $request, Purchase $purchase)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id() ?? 1;
        $purchase->update($validated);

        // Update purchase details if necessary
        if ($request->has('purchaseDetails')) {
            $purchaseDetails = $request->input('purchaseDetails');

            $syncData = [];
            foreach ($purchaseDetails as $purchaseDetail) {
                $purchaseDetail['material_id'] = $purchaseDetail['id'];
                $purchaseDetail['unit_cost'] = $purchaseDetail['unitCost'];
                
                $syncData[$purchaseDetail['material_id']] = [
                    'quantity' => $purchaseDetail['quantity'],
                    'unit_cost' => $purchaseDetail['unit_cost'],
                ];
            }

            $purchase->materials()->sync($syncData);
        }

        return PurchaseResource::make($purchase);
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        // Detach all associated materials before deleting the purchase
        $purchase->materials()->detach();

        // Delete the purchase record
        $purchase->delete();
    }


    public function bulkDelete(Request $request)
    {
        $purchaseIds = $request->input('purchase_ids', []);

        // Ensure there are purchase IDs to delete
        if (empty($purchaseIds)) {
            return response()->json(['message' => 'No purchase IDs provided for deletion'], 422);
        }

        try {
            // Detach materials and delete purchases in a transaction
            DB::transaction(function () use ($purchaseIds) {
                foreach ($purchaseIds as $purchaseId) {
                    $purchase = Purchase::findOrFail($purchaseId);

                    // Detach associated materials
                    $purchase->materials()->detach();

                    // Delete the purchase record
                    $purchase->delete();
                }
            });

            return response()->json(['message' => 'Purchases deleted successfully']);
        } catch (\Exception $e) {
            // Handle any exceptions during the deletion process
            return response()->json(['message' => 'Error deleting purchases', 'error' => $e->getMessage()], 500);
        }
    }
}
