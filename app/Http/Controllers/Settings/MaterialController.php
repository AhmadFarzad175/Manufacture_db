<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Models\Settings\Material;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Settings\MaterialRequest;
use App\Http\Resources\Settings\MaterialResource;
use App\Http\Requests\Settings\StoreMaterialRequest;
use App\Http\Requests\Settings\UpdateMaterialRequest;
use App\Traits\ImageManipulation;

class MaterialController extends Controller
{
    use ImageManipulation;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $materials = Material::with(['materialCategory', 'unit'])->search($search);

        $materials = $perPage ? $materials->latest()->paginate($perPage) : $materials->latest()->get();

        return MaterialResource::collection($materials);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MaterialRequest $request)
    {
        $validated = $request->validated();
        $request->hasFile('image') ? $this->storeImage($request, $validated, 'material_images') : null;
        Material::create($validated);

        return response()->json(['success' => 'Material inserted successfully']);
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
    public function updateMaterial(MaterialRequest $request, Material $material)
    {
        $validated = $request->validated();
        $this->updateImage($material, $request, $validated, 'material_images');

        $material->update($validated);

        return response()->json(['success' => 'Material updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $this->deleteImage($material, 'material_images');

        $material->delete();
        return response()->noContent();
    }

    public function bulkDelete(Request $request)
    {
        $materials = $request->input('materialIds');
        Material::destroy($materials);
        return response()->json(['success' => 'Materials deleted successfully']);
    }
}
