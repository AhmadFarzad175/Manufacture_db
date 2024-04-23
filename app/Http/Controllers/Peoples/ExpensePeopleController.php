<?php

namespace App\Http\Controllers\Peoples;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Peoples\ExpensePeople;
use App\Http\Resources\Peoples\ExpensePeopleResource;

class ExpensePeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        $expensePeoples = ExpensePeople::query()->search($search);

        $expensePeoples = $perPage ? $expensePeoples->latest()->paginate($perPage) : $expensePeoples->latest()->get();

        return ExpensePeopleResource::collection($expensePeoples);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ExpensePeople::create($request->validated());
        return response()->json(['success' => 'Person created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpensePeople $expensePeople)
    {
        return ExpensePeopleResource::make($expensePeople);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpensePeople $expensePeople)
    {
        $expensePeople->update($request->validated());
        return response()->json(['success', 'Person updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpensePeople $expensePeople)
    {
        $expensePeople->delete();
        return response()->json(['success', 'Person deleted successfully']);
    }

    public function bulkDelete(Request $request)
    {
        $expensePeoples = $request->input('xpensePeopleIds');
        ExpensePeople::destroy($expensePeoples);
    }
}
