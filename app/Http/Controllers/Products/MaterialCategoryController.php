<?php

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\MaterialCategoryRequest;
use App\Models\Products\MaterialCategory;
use App\Http\Resources\Products\MaterialCategoryResource;

class MaterialCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $materialCategories = MaterialCategory::query()->search($search);

        $materialCategories = $perPage ? $materialCategories->latest()->paginate($perPage) : $materialCategories->latest()->get();

        return MaterialCategoryResource::collection($materialCategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MaterialCategoryRequest $request)
    {
        $materialCategory = MaterialCategory::create($request->validated());
        return MaterialCategoryResource::make($materialCategory);
    }

    /**
     * Display the specified resource.
     */
    public function show(MaterialCategory $materialCategory)
    {
        return MaterialCategoryResource::make($materialCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MaterialCategoryRequest $request, MaterialCategory $materialCategory)
    {
        $materialCategory->update($request->validated());
        return MaterialCategoryResource::make($materialCategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaterialCategory $materialCategory)
    {
        $materialCategory->delete();
        return response()->noContent();
    }

    public function bulkDelete(Request $request)
    {
        $materials = $request->input('materialCategoryIds');
        MaterialCategory::destroy($materials);
    }
}
