<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use App\Models\Settings\TransferDetails;
use App\Models\Settings\WarehouseProduct;
use App\Models\Settings\WarehouseMaterial;

trait WarehouseSelection
{


    public function WarehouseManipulation($validated, $transferDetail)
    {
        if ($transferDetail['type'] == 0) {
            $fromWarehouse = $this->getWarehouseMaterial($validated['from_warehouse_id'], $transferDetail['productMaterialId']);
            $toWarehouse = $this->getWarehouseMaterial($validated['to_warehouse_id'], $transferDetail['productMaterialId']);

            // Create a new product in warehouse
            if (!$toWarehouse) {
                $toWarehouse = WarehouseMaterial::create([
                    'warehouse_id' => $validated['to_warehouse_id'],
                    'material_id' => $transferDetail['productMaterialId'],
                    'quantity' => 0
                ]);
            }
        }

        elseif ($transferDetail['type'] == 1) {
            $fromWarehouse = $this->getWarehouseProduct($validated['from_warehouse_id'], $transferDetail['productMaterialId']);
            $toWarehouse = $this->getWarehouseProduct($validated['to_warehouse_id'], $transferDetail['productMaterialId']);

            // Create a new product in warehouse
            if (!$toWarehouse) {
                $toWarehouse = WarehouseProduct::create([
                    'warehouse_id' => $validated['to_warehouse_id'],
                    'product_id' => $transferDetail['productMaterialId'],
                    'quantity' => 0
                ]);
            }
        }

        //update the warehouses
        $fromWarehouse->decrement('quantity', $transferDetail['quantity']);
        $toWarehouse->increment('quantity', $transferDetail['quantity']);
    }




    public function updateTransferDetail($transfer, $transferDetail)
    {
        // Get the transfer detail
        $existingDetail = TransferDetails::where('transfer_id', $transfer->id)
            ->where('productMaterial_id', $transferDetail['productMaterialId'])
            ->first();
        
        
        dd($existingDetail);
        if ($existingDetail) {
            // Update existing detail
            $existingDetail->update([
                'type' => $transferDetail['type'],
                'quantity' => $transferDetail['quantity'],
                'unit_cost' => $transferDetail['unitCost'],
            ]);
        } else {
            // Create new transfer detail
            TransferDetails::create([
                'transfer_id' => $transfer->id,
                'productMaterial_id' => $transferDetail['productMaterialId'],
                'type' => $transferDetail['type'],
                'quantity' => $transferDetail['quantity'],
                'unit_cost' => $transferDetail['unitCost'],
            ]);
        }

        // Update warehouse
        $this->warehouseManipulation($transfer, $transferDetail);
    }


    public function getWarehouseMaterial($warehouseId, $materialId)
    {
        return WarehouseMaterial::where('warehouse_id', $warehouseId)
            ->where('material_id', $materialId)
            ->first();
    }

    public function getWarehouseProduct($warehouseId, $materialId)
    {
        return WarehouseProduct::where('warehouse_id', $warehouseId)
            ->where('product_id', $materialId)
            ->first();
    }
}
