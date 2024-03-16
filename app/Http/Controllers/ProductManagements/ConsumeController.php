<?php

namespace App\Http\Controllers\ProductManagements;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductManagements\Consume;
use App\Http\Resources\ProductManagements\ConsumeResource;

class ConsumeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $consumes = Consume::with(['warehouse', 'materials'])->search($search);
        $consumes = $perPage ? $consumes->latest()->paginate($perPage) : $consumes->latest()->get();
        return ConsumeResource::collection($consumes);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(ConsumeRequest $request)
    // {
    //     $consume = Consume::create($request->validated());

    //     foreach ($request->input('consumeDetails') as $consumeDetail) {
    //         $consume->materials()->attach($consumeDetail['material_id'], [
    //             'quantity' => $consumeDetail['quantity'],
    //         ]);
    //     }
    //     return ConsumeResource::make($consume);
    // }

    /**
     * Display the specified resource.
     */
    public function show(Consume $consume)
    {
        return ConsumeResource::make($consume);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Consume $consume)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consume $consume)
    {
        //
    }
}
