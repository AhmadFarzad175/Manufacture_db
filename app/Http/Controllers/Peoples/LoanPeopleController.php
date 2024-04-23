<?php

namespace App\Http\Controllers\Peoples;

use Illuminate\Http\Request;
use App\Models\Peoples\LoanPeople;
use App\Http\Controllers\Controller;
use App\Http\Requests\Peoples\LoanPeopleRequest;
use App\Http\Resources\Peoples\LoanPeopleResource;

class LoanPeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        $loanPeoples = LoanPeople::query()->search($search);

        $loanPeoples = $perPage ? $loanPeoples->latest()->paginate($perPage) : $loanPeoples->latest()->get();

        return LoanPeopleResource::collection($loanPeoples);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoanPeopleRequest $request)
    {
        LoanPeople::create($request->validated());
        return response()->json(['success' => 'Person created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(LoanPeople $loanPeople)
    {
        return LoanPeopleResource::make($loanPeople);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LoanPeopleRequest $request, LoanPeople $loanPeople)
    {
        $loanPeople->update($request->validated());
        return response()->json(['success', 'Person updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoanPeople $loanPeople)
    {
        $loanPeople->delete();
        return response()->json(['success', 'Person deleted successfully']);
    }

    public function bulkDelete(Request $request)
    {
        $loanPeoples = $request->input('loanPeopleIds');
        LoanPeople::destroy($loanPeoples);
    }
}
