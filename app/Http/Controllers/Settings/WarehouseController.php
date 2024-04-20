<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Models\Settings\Warehouse;
use App\Http\Controllers\Controller;
use App\Http\Resources\WarehouseResource;
use App\Http\Requests\Settings\WarehouseRequest;


class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $warehouses = Warehouse::query()->search($search);

        $warehouses = $perPage ? $warehouses->latest()->paginate($perPage) : $warehouses->latest()->get();

        return WarehouseResource::collection($warehouses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WarehouseRequest $request)
    {
        Warehouse::create($request->validated());
        return response()->json(['success', 'Warehouse created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse)
    {
        return WarehouseResource::make($warehouse);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WarehouseRequest $request, Warehouse $warehouse)
    {
        $warehouse->update($request->validated());
        return response()->json(['success', 'Warehouse updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return response()->json(['success', 'Warehouse deleted successfully']);
    }

    public function bulkDelete(Request $request)
    {
        $warehouses = $request->input('warehouseIds');
        Warehouse::destroy($warehouses);
        return response()->json(['success', 'Warehouses deleted successfully']);
    }
}
