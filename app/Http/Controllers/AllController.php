<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings\Account;
use App\Models\Settings\Currency;

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
  
}
