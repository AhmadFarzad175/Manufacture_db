<?php

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Models\Products\Unit;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\UnitRequest;
use App\Http\Resources\Products\UnitResource;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $units = Unit::query()->search($search);

        $units = $perPage ? $units->latest()->paginate($perPage) : $units->latest()->get();

        return UnitResource::collection($units);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitRequest $request)
    {
        $unit = Unit::create($request->validated());
        return UnitResource::make($unit);
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        return UnitResource::make($unit);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnitRequest $request, Unit $unit)
    {
        $unit->update($request->validated());
        return UnitResource::make($unit);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return response()->noContent();
    }

    public function bulkDelete(Request $request)
    {
        $units = $request->input('unitIds');
        Unit::destroy($units);
    }
}
