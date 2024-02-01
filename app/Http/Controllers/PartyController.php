<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;
use App\Http\Requests\PartyRequest;
use App\Http\Resources\PartyResource;
use App\Http\Requests\StorePartyRequest;
use App\Http\Requests\UpdatePartyRequest;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PartyResource(Party::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PartyRequest $request)
    {
        $validated = $request->validated();
        Party::create($validated);
        return 'party inserted successfully';
    }

    /**
     * Display the specified resource.
     */
    public function show(Party $party)
    {
        return new PartyResource($party);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PartyRequest $request, Party $party)
    {
        $validated = $request->validated();
        $party->update($validated);
        return $party;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Party $party)
    {
        $party->delete();
        return 'party deleted successfully';
    }
}
