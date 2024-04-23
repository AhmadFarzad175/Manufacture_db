<?php

namespace App\Http\Controllers\peoples;

use Illuminate\Http\Request;
use App\Models\Peoples\Supplier;
use App\Http\Controllers\Controller;
use App\Http\Requests\Peoples\SupplierRequest;
use App\Http\Resources\Peoples\SupplierResource;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        $suppliers = Supplier::query()->search($search);

        $suppliers = $perPage ? $suppliers->latest()->paginate($perPage) : $suppliers->latest()->get();

        return SupplierResource::collection($suppliers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {
        Supplier::create($request->validated());
        return response()->json(['success' => 'Supplier created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return SupplierResource::make($supplier);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->validated());
        return response()->json(['success', 'Supplier updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return response()->json(['success', 'Supplier deleted successfully']);
    }

    public function bulkDelete(Request $request)
    {
        $suppliers = $request->input('supplierIds');
        Supplier::destroy($suppliers);
    }
}
