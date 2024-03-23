<?php

namespace App\Http\Controllers\ProductManagements;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductManagements\Consume;
use App\Models\Settings\WarehouseMaterial;
use App\Http\Requests\ProductManagements\ConsumeRequest;
use App\Http\Resources\ProductManagements\ConsumeResource;

class ConsumeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $consumes = Consume::with(['warehouse', 'materials'])->search($search);
        $consumes = $perPage ? $consumes->latest()->paginate($perPage) : $consumes->latest()->get();
        return ConsumeResource::collection($consumes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConsumeRequest $request)
    {

        DB::beginTransaction();

        try {
            $consume = Consume::create($request->validated());

            foreach ($request->input('consumeDetails') as $consumeDetail) {
                //MERGE THE NAME OF MATERIAL ID
                $consumeDetail['material_id'] = $consumeDetail['materialId'];

                $consume->materials()->attach($consumeDetail['material_id'], [
                    'quantity' => $consumeDetail['quantity'],
                ]);

                // Find the corresponding warehouse material for this consume detail
                $warehouseMaterial = WarehouseMaterial::where('warehouse_id', $request->warehouseId)
                    ->where('material_id', $consumeDetail['material_id'])
                    ->firstOrFail();

                // Check if there's enough quantity in the warehouse
                if ($warehouseMaterial->quantity < $consumeDetail['quantity']) {
                    throw new \Exception('Insufficient quantity in the warehouse for material ID: ' . $consumeDetail['material_id']);
                }

                // Decrease the quantity in the warehouseMaterial
                $warehouseMaterial->decrement('quantity', $consumeDetail['quantity']);
            }

            DB::commit();

            return ConsumeResource::make($consume);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Warehouse material not found.'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Consume $consume)
    {
        return ConsumeResource::make($consume);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConsumeRequest $request, Consume $consume)
    {
        DB::beginTransaction();

        try {
            $oldDetails = $consume->materials()->pluck('material_id', 'quantity')->toArray();
            $consume->update($request->validated());

            // Detach existing materials
            $consume->materials()->detach();

            // Attach updated materials
            foreach ($request->input('consumeDetails') as $consumeDetail) {
                //MERGE THE NAME OF MATERIAL ID
                $consumeDetail['material_id'] = $consumeDetail['materialId'];

                $consume->materials()->attach($consumeDetail['material_id'], [
                    'quantity' => $consumeDetail['quantity'],
                ]);

                // Find the corresponding warehouse material for this consume detail
                $warehouseMaterial = WarehouseMaterial::where('warehouse_id', $request->warehouseId)
                    ->where('material_id', $consumeDetail['material_id'])
                    ->firstOrFail();

                // Calculate the difference in quantity
                $newQuantity = $consumeDetail['quantity'];
                $oldQuantity = isset($oldDetails[$newQuantity]) ? $oldDetails[$newQuantity] : 0;
                $quantityDifference = $newQuantity - $oldQuantity;

                // Check if there's enough quantity in the warehouse
                if ($warehouseMaterial->quantity < $quantityDifference) {
                    throw new \Exception('Insufficient quantity in the warehouse for material ID: ' . $consumeDetail['material_id']);
                }

                // Decrease or increase the quantity in the warehouseMaterial
                $warehouseMaterial->decrement('quantity', $quantityDifference);
            }

            DB::commit();

            return ConsumeResource::make($consume);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Consume not found.'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consume $consume)
    {
        //
    }
}
