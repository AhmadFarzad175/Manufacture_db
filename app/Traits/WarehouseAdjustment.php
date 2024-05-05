<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use App\Models\Settings\TransferDetails;
use App\Models\Settings\WarehouseProduct;
use App\Models\Settings\WarehouseMaterial;

trait WarehouseAdjustment
{
    use WarehouseSelection;
    public function warehouseAdjustment($validated, $adjustmentDetail)
    {
        if ($adjustmentDetail['kind'] == 0) {
            $warehouse = $this->getWarehouseMaterial($validated['warehouse_id'], $adjustmentDetail['productMaterialId']);
        } else {
            $warehouse = $this->getWarehouseProduct($validated['warehouse_id'], $adjustmentDetail['productMaterialId']);
        }

        $adjustmentDetail['type'] == 0 ?
            $warehouse->increment('quantity', $adjustmentDetail['amount']) :
            $warehouse->decrement('quantity', $adjustmentDetail['amount']);
    }



    public function updateWarehouseAdjustment($adjustment, $adjustmentDetail){

    }
}
