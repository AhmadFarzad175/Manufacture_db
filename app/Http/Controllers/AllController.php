<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings\Unit;
use App\Models\Peoples\Supplier;
use App\Models\Settings\Currency;
use App\Models\Peoples\ExpensePeople;
use App\Models\Settings\ExpenseProduct;
use App\Models\Settings\ExpenseCategory;
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

        return response()->json(['data' => $allData]);
    }

    public function unitCategory()
    {   //all controller 
        $allData = [
            'unit' => Unit::select('id', 'name')->get(),
            'materialCategory' => MaterialCategory::select('id', 'name')->get(),
        ];

        return response()->json(['data' => $allData]);
    }

    public function personCategory()
    {
        $allData = [
            'expensePeople' => ExpensePeople::select('id', 'name')->get(),
            'expenseCategory' => ExpenseCategory::select('id', 'name')->get(),
        ];

        return response()->json(['data' => $allData]);
    }

    public function personExpenseProduct()
    {
        $allData = [
            'supplier' => Supplier::select('id', 'name')->get(),
            'expensePeople' => ExpensePeople::select('id', 'name')->get(),
            'expenseProduct' => ExpenseProduct::select('id', 'name', 'price', 'code')->get(),
        ];

        return response()->json(['data' => $allData]);
    }


}
