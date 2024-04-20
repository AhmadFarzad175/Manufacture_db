<?php

namespace App\Http\Controllers\Settings;

use App\Models\Settings\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\CurrencyRequest;
use App\Http\Resources\Settings\CurrencyResource;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $currencies = Currency::query()->search($search);

        $currencies = $perPage ? $currencies->latest()->paginate($perPage) : $currencies->latest()->get();

        return CurrencyResource::collection($currencies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CurrencyRequest $request)
    {
        Currency::create($request->validated());
        return response()->json(['success', 'Currency created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency)
    {
        return CurrencyResource::make($currency);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CurrencyRequest $request, Currency $currency)
    {
        $currency->update($request->validated());
        return response()->json(['success', 'Currency updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();
        return response()->json(['success', 'Currency deleted successfully']);
    }

    public function bulkDelete(Request $request)
    {
        $currencies = $request->input('currencyIds');
        Currency::destroy($currencies);
        return response()->json(['success', 'Currencies deleted successfully']);
    }
}
