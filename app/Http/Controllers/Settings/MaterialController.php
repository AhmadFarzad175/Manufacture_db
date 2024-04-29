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

        if ($request->hasFile('image')) {
            $validated['image'] = $validated['image']->store('material_images/', 'public');
        }

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
    public function updateMaterial(UpdateMaterialRequest $request, Material $material)
    {
        $validated = $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $oldImagePath = public_path('storage/material_images/' . basename($material->image));

            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
            $validated['image'] = $request['image']->store('material_images/', 'public');
        }
        if (!isset($request['image'])) {
            $oldImagePath = public_path('storage/material_images/' . basename($material->image));

            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
            $validated['image'] = $imagePath;
        }
        if (is_string($request['image'])) {
            $validated['image'] = $material->image;
        }
        $material->update($validated);

        return response()->json(['success' => 'Material updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $imagePath = public_path('storage/product_images/' . basename($material->image));
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $material->delete();
        return response()->noContent();
    }

    public function bulkDelete(Request $request)
    {
        $materials = $request->input('materialIds');
        Material::destroy($materials);
        return response()->json(['success', 'Materials deleted successfully']);
    }
}
