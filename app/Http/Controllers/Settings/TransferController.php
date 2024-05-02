<?php

namespace App\Http\Controllers\Settings;

use App\Traits\WarehouseSelection;
use Illuminate\Http\Request;
use App\Models\Settings\Transfer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Settings\TransferDetails;
use App\Models\Settings\WarehouseProduct;
use App\Models\Settings\WarehouseMaterial;
use App\Http\Requests\Settings\TransferRequest;
use App\Http\Resources\Settings\TransferResource;

class TransferController extends Controller
{
    use WarehouseSelection;
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

            TransferDetails::create([
                'transfer_id' => $transfer->id,
                'productMaterial_id' => $transferDetail['productMaterialId'],
                'type' => $transferDetail['type'],
                'quantity' => $transferDetail['quantity'],
                'unit_cost' => $transferDetail['unitCost'],
            ]);

            $this->WarehouseManipulation($validated, $transferDetail);
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
    public function update(TransferRequest $request, Transfer $transfer)
    {
        $validated = $request->validated();
        $transfer->update($validated);

        // Handle transfer details
        foreach ($validated['transferDetails'] as $transferDetail) {
            $this->updateTransferDetail($transfer, $transferDetail);
        }

        return TransferResource::make($transfer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transfer $transfer)
    {
        // DB::beginTransaction();
        // try {
        // Delete associated transfer details
        // return ($transfer->transferDetails);
        $transfer->transferDetails()->delete();

        // Delete the transfer record
        $transfer->delete();

        // DB::commit();
        return response()->json(['message' => 'Transfer deleted successfully']);
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     // Handle the exception, log it, or return an error response
        //     return response()->json(['message' => 'An error occurred while processing the request.'], 500);
        // }
    }
}
