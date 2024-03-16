<?php

namespace App\Http\Controllers\Expenses;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Expenses\BillablePayment;
use App\Http\Requests\Expenses\BillablePaymentRequest;
use App\Http\Resources\Expenses\BillablePaymentResource;


class BillablePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $billablePayments = BillablePayment::with('expensePeople')->search($search);

        $billablePayments = $perPage ? $billablePayments->latest()->paginate($perPage) : $billablePayments->latest()->get();

        return BillablePaymentResource::collection($billablePayments);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(BillablePaymentRequest $request)
    {
        $billablePayment = BillablePayment::create($request->validated());
        return BillablePaymentResource::make($billablePayment);
    }

    /**
     * Display the specified resource.
     */
    public function show(BillablePayment $billablePayment)
    {
        return BillablePaymentResource::make($billablePayment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BillablePaymentRequest $request, BillablePayment $billablePayment)
    {
        $billablePayment->update($request->validated());
        return BillablePaymentResource::make($billablePayment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BillablePayment $billablePayment)
    {
        $billablePayment->delete();
        return response()->noContent();
    }

    public function bulkDelete(Request $request)
    {
        $billablePayments = $request->input('billablePaymentIds');
        BillablePayment::destroy($billablePayments);
    }
}
