<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use App\Models\Settings\TransferDetails;
use App\Models\Settings\WarehouseProduct;
use App\Models\Settings\WarehouseMaterial;

trait WarehouseSelection
{


    public function WarehouseManipulation($validated, $transferDetail, $oldQuantity = null)
    {
        if ($transferDetail['kind'] == 0) {
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
        } elseif ($transferDetail['kind'] == 1) {
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
        // just for update method
        if ($oldQuantity) {
            $qtyDiff = $oldQuantity - $transferDetail['quantity'];
            $fromWarehouse->increment('quantity', $qtyDiff);
            $toWarehouse->decrement('quantity', $qtyDiff);

        }else{
            //update the warehouses in store method
            $fromWarehouse->decrement('quantity', $transferDetail['quantity']);
            $toWarehouse->increment('quantity', $transferDetail['quantity']);
        }

    }



    //Update method
    public function updateTransferDetail($transfer, $transferDetail)
    {
        // Get the transfer detail
        $existingDetail = TransferDetails::where('transfer_id', $transfer->id)
            ->where('productMaterial_id', $transferDetail['productMaterialId'])
            ->where('kind', $transferDetail['kind'])
            ->first();

        // Store the old quantity if the existing detail exists
        $oldQuantity = $existingDetail ? $existingDetail->quantity : 0;

        // Update existing detail
        if ($existingDetail) {
            $existingDetail->update([
                'kind' => $transferDetail['kind'],
                'quantity' => $transferDetail['quantity'],
                'unit_cost' => $transferDetail['unitCost'],
            ]);
        } else {
            // Create new transfer detail
            TransferDetails::create([
                'transfer_id' => $transfer->id,
                'productMaterial_id' => $transferDetail['productMaterialId'],
                'kind' => $transferDetail['kind'],
                'quantity' => $transferDetail['quantity'],
                'unit_cost' => $transferDetail['unitCost'],
            ]);
        }

        // Update warehouse
        $this->warehouseManipulation($transfer, $transferDetail, $oldQuantity);
    }











    // helper methods
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
