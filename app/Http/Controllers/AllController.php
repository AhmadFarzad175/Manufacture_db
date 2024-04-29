<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings\Unit;
use App\Models\Settings\Account;
use App\Models\Settings\Currency;
use App\Models\Settings\MaterialCategory;

class AllController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function currency()
    {   //all controller 
            $allData = [
                'currencies' => Currency::select('id', 'symbol')->get(),
                
            ];
    
            return response()->json(['data'=>$allData]);
    }

    public function unitCategory()
    {   //all controller 
            $allData = [
                'unit' => Unit::select('id', 'name')->get(),
                'materialCategoryId' => MaterialCategory::select('id', 'name')->get(),
            ];
    
            return response()->json(['data'=>$allData]);
    }
  
}
