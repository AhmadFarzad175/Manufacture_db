<?php

namespace App\Http\Controllers\Peoples;

use App\Models\Peoples\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Peoples\CustomerRequest;
use App\Http\Resources\Peoples\CustomerResource;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        $customers = Customer::query()->search($search);

        $customers = $perPage ? $customers->latest()->paginate($perPage) : $customers->latest()->get();

        return CustomerResource::collection($customers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        Customer::create($request->validated());
        return response()->json(['success' => 'Customer created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return CustomerResource::make($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        return response()->json(['success', 'Customer updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(['success', 'Customer deleted successfully']);
    }

    public function bulkDelete(Request $request)
    {
        $customers = $request->input('customerIds');
        Customer::destroy($customers);
    }
}
