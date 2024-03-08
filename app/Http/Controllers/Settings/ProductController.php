<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Models\Settings\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProductRequest;
use App\Http\Resources\Settings\ProductResource;
use Illuminate\Support\Facades\Log;

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
    public function store(Request $request)
    {
        // return ($request);
        $validate = $request->validate([
            'code' => 'required',
            'name' => 'required|string',
            'image' => 'nullable|string|image',
            'material_category_id' => 'required',
            'unit_id' => 'required',
            'price' => 'required',
            'stock' => 'nullable',
            'stock_alert' => 'nullable',
            'description' => 'nullable|string',
        ]);
        Log::info('validate', [$validate]);
        return ($validate);
        $imagePath = null;
        if ($validate['image']) {
            $validate['image'] = $validate['image']->store('product_images/', 'public');
        }
        Product::create($validate);


        // $imagePath = null;
        // if ($request->hasFile('image')) {
        //     $imagePath = $request->file('image')->store('product_images/', 'public');
        // }

        // // Create the listing with the validated data
        // Product::create([
        //     'code' => $request->input('code'),
        //     'price' => $request->input('price'),
        //     'name' => $request->input('name'),
        //     'stock_alert' => $request->input('stock_alert'),
        //     'material_category_id' => $request->input('material_category_id'),
        //     'unit_id' => $request->input('unit_id'),
        //     'description' => $request->input('description'),
        //     'image' => $imagePath
        // ]);

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
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return ProductResource::make($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
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
