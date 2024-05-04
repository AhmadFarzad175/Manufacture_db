<?php

namespace App\Http\Controllers\Settings;

use App\Traits\WarehouseAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Settings\Adjustment;
use App\Http\Controllers\Controller;
use App\Models\Settings\AdjustmentDetails;
use App\Http\Requests\Settings\AdjustmentRequest;
use App\Http\Resources\Settings\AdjustmentResource;

class AdjustmentController extends Controller
{
    use WarehouseAdjustment;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $adjustment = Adjustment::with(['warehouse', 'adjustmentDetails'])->search($search);

        $adjustment = $adjustment->latest()->paginate($perPage);

        return AdjustmentResource::collection($adjustment);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdjustmentRequest $request)
    {
        // DB::beginTransaction();

        // try {
        // return $request;
        $validated = $request->validated();
        $adjustment = Adjustment::create($validated);

        //INSERT INTO PIVOT TABLE
        foreach ($validated['adjustmentDetails'] as $adjustmentDetail) {

            AdjustmentDetails::create([
                'adjustment_id' => $adjustment->id,
                'productMaterial_id' => $adjustmentDetail['productMaterialId'],
                'type' => $adjustmentDetail['type'],
                'kind' => $adjustmentDetail['kind'],
                'amount' => $adjustmentDetail['amount'],
            ]);

            $this->warehouseAdjustment($validated, $adjustmentDetail);
        }



        DB::commit();
        return AdjustmentResource::make($adjustment);
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     // Handle the exception, log it, or return an error response
        //     return response()->json(['message' => 'An error occurred while processing the request.'], 500);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Adjustment $adjustment)
    {
        return AdjustmentResource::make($adjustment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Adjustment $adjustment)
    {
        $validated = $request->validated();
        $adjustment->update($validated);

        // Handle adjust$adjustment details
        foreach ($validated['adjustmentDetails'] as $adjustmentDetail) {
            $this->updateWarehouseAdjustment($adjustment, $adjustmentDetail);
        }

        return AdjustmentResource::make($adjustment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adjustment $adjustment)
    {
        //
    }
}
