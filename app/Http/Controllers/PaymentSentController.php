<?php

namespace App\Http\Controllers;

use App\Models\PaymentSend;
use App\Models\PaymentSent;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentSentRequest;
use App\Http\Resources\PaymentSentResource;


class PaymentSentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');
        $paymentSent = PaymentSent::query()->search($search);
        $paymentSent = $perPage ? $paymentSent->latest()->paginate($perPage) : $paymentSent->latest()->get();
        return PaymentSentResource::collection($paymentSent);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentSentRequest $request)
    {
        $paymentSent = PaymentSent::create($request->validated());
        return PaymentSentResource::make($paymentSent);
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentSent $paymentSent)
    {
        return PaymentSentResource::make($paymentSent);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentSentRequest $request, PaymentSent $paymentSent)
    {
        $paymentSent->update($request->validated());
        return PaymentSentResource::make($paymentSent);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentSent $paymentSent)
    {
        $paymentSent->delete();
        return response()->noContent();
    }

    public function bulkDelete(Request $request)
    {
        $paymentSent = $request->input('paymentSentIds');
        PaymentSent::destroy($paymentSent);
    }
}
