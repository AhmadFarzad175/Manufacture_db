<?php

namespace App\Http\Controllers\Settings;

use App\Traits\ImageManipulation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Settings\ExpenseProduct;
use App\Http\Requests\Settings\ExpenseProductRequest;
use App\Http\Resources\Settings\ExpenseProductResource;


class ExpenseProductController extends Controller
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
        $expenseProducts = ExpenseProduct::with(['expenseCategory', 'unit'])->search($search);

        $expenseProducts = $perPage ? $expenseProducts->latest()->paginate($perPage) : $expenseProducts->latest()->get();

        return ExpenseProductResource::collection($expenseProducts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseProductRequest $request)
    {
        $validated = $request->validated();
        // return $validated['image'];

        $request->hasFile('image') ? $this->storeImage($request, $validated, 'expense_images') : null;

        ExpenseProduct::create($validated);

        return response()->json(['success' => 'Product inserted successfully']);
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
    public function updateExpenseProduct(ExpenseProductRequest $request, ExpenseProduct $expenseProduct)
    {
        $validated = $request->validated();

        $this->updateImage($expenseProduct, $request, $validated, 'expense_images');

        $expenseProduct->update($validated);

        return response()->json(['success' => 'Product updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseProduct $expenseProduct)
    {
        $this->deleteImage($expenseProduct, 'expense_images');

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
