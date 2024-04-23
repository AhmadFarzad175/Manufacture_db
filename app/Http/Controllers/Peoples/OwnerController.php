<?php

namespace App\Http\Controllers\Peoples;

use Illuminate\Http\Request;
use App\Models\Peoples\Owner;
use App\Http\Controllers\Controller;
use App\Http\Requests\Peoples\OwnerRequest;
use App\Http\Resources\Peoples\OwnerResource;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        $owners = Owner::query()->search($search);

        $owners = $perPage ? $owners->latest()->paginate($perPage) : $owners->latest()->get();

        return OwnerResource::collection($owners);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(OwnerRequest $request)
    {
        Owner::create($request->validated());
        return response()->json(['success' => 'Owner created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Owner $owner)
    {
        return OwnerResource::make($owner);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OwnerRequest $request, Owner $owner)
    {
        $owner->update($request->validated());
        return response()->json(['success', 'Owner updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Owner $owner)
    {
        $owner->delete();
        return response()->json(['success', 'Owner deleted successfully']);
    }

    public function bulkDelete(Request $request)
    {
        $owners = $request->input('ownerIds');
        Owner::destroy($owners);
    }
}
