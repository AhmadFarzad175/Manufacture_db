<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Settings\ExpenseProduct;
use App\Http\Resources\Settings\ExpenseProductResource;


class ExpenseProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $expenseProducts = ExpenseProduct::with(['expenseCategory', 'unit'])->search($search);

        $expenseProducts = $perPage ? $expenseProducts->latest()->paginate($perPage) : $expenseProducts->latest()->get();

        return ExpenseProductResource::collection($expenseProducts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $validated['image']->store('expense_images/', 'public');
        }

        ExpenseProduct::create($validated);

        return response()->json(['success' => 'Product inserted successfully']);

        //! MAKE A TRAIT FOR STORE AND UPDATE
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseProduct $expenseProduct)
    {
        return ExpenseProductResource::make($expenseProduct);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpenseProduct $expenseProduct)
    {
        $validated = $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $oldImagePath = public_path('storage/expense_images/' . basename($expenseProduct->image));

            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
            $validated['image'] = $request['image']->store('expense_images/', 'public');
        }
        if (!isset($request['image'])) {
            $oldImagePath = public_path('storage/expense_images/' . basename($expenseProduct->image));

            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
            $validated['image'] = $imagePath;
        }
        if (is_string($request['image'])) {
            $validated['image'] = $expenseProduct->image;
        }
        $expenseProduct->update($validated);

        return response()->json(['success' => 'Product updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseProduct $expenseProduct)
    {
        $imagePath = public_path('storage/expense_images/' . basename($expenseProduct->image));
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $expenseProduct->delete();
        return response()->noContent();
    }

    public function bulkDelete(Request $request)
    {
        $expenseProducts = $request->input('expenseProductIds');
        ExpenseProduct::destroy($expenseProducts);
        return response()->json(['success', 'Products deleted successfully']);
    }
}
