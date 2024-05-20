<?php

namespace App\Http\Controllers\Settings;

use App\Traits\ImageManipulation;
use Illuminate\Http\Request;
use App\Models\Settings\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Settings\ProductRequest;
use App\Http\Resources\Settings\ProductResource;
use App\Http\Requests\Settings\StoreProductRequest;
use App\Http\Requests\Settings\UpdateProductRequest;

class ProductController extends Controller
{
    use ImageManipulation;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');
        $wareHouse = $request->input('wareHouse');


        // Eager load relationships and apply search
        $products = Product::with(['materialCategory', 'unit'])->search($search, $wareHouse);

        $products = $perPage ? $products->latest()->paginate($perPage) : $products->latest()->get();

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        $request->hasFile('image') ? $this->storeImage($request, $validated, 'product_images') : null;

        Product::create($validated);

        return response()->json(['success' => 'product inserted successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return ProductResource::make($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProduct(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $this->updateImage($product, $request, $validated, 'product_images');

        $product->update($validated);

        return response()->json(['success' => 'Product updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->deleteImage($product, 'product_images');

        $product->delete();
        return response()->noContent();
    }

    public function bulkDelete(Request $request)
    {
        $products = $request->input('productIds');
        Product::destroy($products);
        return response()->json(['success', 'Products deleted successfully']);
    }
}
