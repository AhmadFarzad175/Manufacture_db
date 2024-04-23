<?php

namespace App\Http\Controllers\Settings;

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
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $products = Product::with(['materialCategory', 'unit'])->search($search);

        $products = $perPage ? $products->latest()->paginate($perPage) : $products->latest()->get();

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $validated['image']->store('product_images/', 'public');
        }

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
    public function updateProduct(UpdateProductRequest $request, Product $product)
    {

        $validated = $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $oldImagePath = public_path('storage/product_images/' . basename($product->image));

            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
            $validated['image'] = $request['image']->store('product_images/', 'public');
        }
        if (!isset($request['image'])) {
            $oldImagePath = public_path('storage/product_images/' . basename($product->image));

            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
            $validated['image'] = $imagePath;
        }
        if (is_string($request['image'])) {
            $validated['image'] = $product->image;
        }
        $product->update($validated);

        return response()->json(['success' => 'Product updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $imagePath = public_path('storage/product_images/' . basename($product->image));
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
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
