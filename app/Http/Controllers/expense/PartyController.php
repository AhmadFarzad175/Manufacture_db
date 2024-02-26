<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;
use App\Http\Requests\PartyRequest;
use App\Http\Resources\PartyResource;


class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');
        $parties = Party::query()->search($search);
        $parties = $perPage ? $parties->latest()->paginate($perPage) : $parties->latest()->get();
        return PartyResource::collection($parties);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PartyRequest $request)
    {
        $party = Party::create($request->validated());
        return PartyResource::make($party);
    }

    /**
     * Display the specified resource.
     */
    public function show(Party $party)
    {
        return PartyResource::make($party);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PartyRequest $request, Party $party)
    {
        $party->update($request->validated());
        return PartyResource::make($party);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Party $party)
    {
        $party->delete();
        return response()->noContent();
    }

    public function bulkDelete(Request $request)
    {
        $parties = $request->input('partyIds');
        Party::destroy($parties);
    }
}
