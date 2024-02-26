<?php

namespace App\Http\Controllers\Product;

use App\Models\Product\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MaterialResource;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $materials = Material::with(['materialCategory', 'unit'])
            ->search($search);

        $materials = $perPage ? $materials->latest()->paginate($perPage) : $materials->latest()->get();

        return MaterialResource::collection($materials);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $material = Material::create($request->validated());
        return MaterialResource::make($material);
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        return MaterialResource::make($material);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $material->update($request->validated());
        return MaterialResource::make($material);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $material->delete();
        return response()->noContent();
    }

    public function bulkDelete(Request $request)
    {
        $materials = $request->input('materialIds');
        Material::destroy($materials);
    }
}
