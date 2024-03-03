<?php

namespace App\Http\Controllers\Purchases;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Purchases\Purchase;
use App\Http\Controllers\Controller;
use App\Http\Requests\Purchases\PurchaseRequest;
use App\Http\Resources\Purchases\PurchaseResource;
use App\Http\Resources\Purchases\PurchaseIndexResource;

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
        $purchases = Purchase::with(['shipments', 'materials', 'user', 'currency', 'supplier'])->search($search);

        $purchases = $perPage ? $purchases->latest()->paginate($perPage) : $purchases->latest()->get();

        return PurchaseIndexResource::collection($purchases);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PurchaseRequest $request)
    {
        $purchase = Purchase::create($request->validated());

        foreach ($request->input('purchaseDetails') as $purchaseDetail) {
            $purchase->materials()->attach($purchaseDetail['material_id'], [
                'quantity' => $purchaseDetail['quantity'],
                'unit_cost' => $purchaseDetail['unit_cost'],
            ]);
        }
        return PurchaseResource::make($purchase);
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
        $purchase->update($request->validated());

        // Update purchase details if necessary
        if ($request->has('purchaseDetails')) {
            $purchaseDetails = $request->input('purchaseDetails');

            $syncData = [];
            foreach ($purchaseDetails as $purchaseDetail) {
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
