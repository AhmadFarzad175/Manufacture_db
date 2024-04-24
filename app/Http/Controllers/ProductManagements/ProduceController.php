<?php

namespace App\Http\Controllers\ProductManagements;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Settings\WarehouseProduct;
use App\Models\ProductManagements\Produce;
use App\Models\ProductManagements\ProduceDetails;
use App\Http\Requests\ProductManagements\ProduceRequest;
use App\Http\Resources\ProductManagements\ProduceResource;

class ProduceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $produces = Produce::with(['warehouse', 'products'])->search($search);
        $produces = $produces->latest()->paginate($perPage);
        return ProduceResource::collection($produces);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProduceRequest $request)
    {

        DB::beginTransaction();

        try {
            $produce = Produce::create($request->validated());

            foreach ($request->input('produceDetails') as $produceDetail) {
                //MERGE THE NAME OF MATERIAL ID
                $produceDetail['product_id'] = $produceDetail['productId'];

                $produce->products()->attach($produceDetail['product_id'], [
                    'quantity' => $produceDetail['quantity'],
                ]);

                // Find the corresponding warehouse product for this produce detail
                $warehouseProduct = WarehouseProduct::where('warehouse_id', $request->warehouseId)
                    ->where('product_id', $produceDetail['product_id'])
                    ->firstOrFail();

                // Check if there's enough quantity in the warehouse
                if ($warehouseProduct->quantity < $produceDetail['quantity']) {
                    throw new \Exception('Insufficient quantity in the warehouse for product ID: ' . $produceDetail['product_id']);
                }

                // Decrease the quantity in the warehouseProduct
                $warehouseProduct->increment('quantity', $produceDetail['quantity']);
            }

            DB::commit();

            return ProduceResource::make($produce);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Warehouse product not found.'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Produce $produce)
    {
        return ProduceResource::make($produce);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProduceRequest $request, Produce $produce)
    { //! if we store 2 records and in update we just send one record. it makes a problem!
        // DB::beginTransaction();

        // try {
        $produce->update($request->validated());

        // Attach updated products
        $syncData = [];
        foreach ($request->input('produceDetails') as $produceDetail) {
            $produceDetail['product_id'] = $produceDetail['productId'];


            // Find the corresponding warehouse product for this produce detail
            $warehouseProduct = WarehouseProduct::where('warehouse_id', $request->warehouseId)
                ->where('product_id', $produceDetail['product_id'])
                ->first();

            // 1_ old quantity update for warehouse product 
            $newQty = $produceDetail['quantity'];
            $oldQty = ProduceDetails::where('produce_id', $produce->id)->where('product_id', $produceDetail['product_id'])
                ->pluck('quantity')->first();

            $qtyDiff = $newQty - $oldQty;

            // Check if there's enough quantity in the warehouse
            if ($warehouseProduct->quantity < $qtyDiff) {
                throw new \Exception('Insufficient quantity in the warehouse for product ID: ' . $produceDetail['product_id']);
            }

            // Decrease or increase the quantity in the warehouseProduct
            $warehouseProduct->decrement('quantity', $qtyDiff);



            $syncData[$produceDetail['product_id']] = [
                'quantity' => $produceDetail['quantity'],
            ];
        }
        $produce->products()->sync($syncData);

        // DB::commit();

        return ProduceResource::make($produce);
        // } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        //     DB::rollBack();
        //     return response()->json(['error' => 'Produce not found.'], 404);
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return response()->json(['error' => $e->getMessage()], 400);
        // }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produce $produce)
    {
        DB::beginTransaction();

        try {
        // Retrieve produce details
        $produceDetails = $produce->products()->pluck('product_id', 'quantity');
        // return $produceDetails;


        // Update warehouse products
        foreach ($produceDetails as $quantity => $productId) {
            $warehouseProduct = WarehouseProduct::where('warehouse_id', $produce->warehouse_id)
                ->where('product_id', $productId)
                ->firstOrFail();
            $warehouseProduct->increment('quantity', $quantity);
        }

        // Detach all produce details
        $produce->products()->detach();

        // Delete the produce
        $produce->delete();

        DB::commit();

        return response()->json(['message' => 'Produce deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
