<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentReceived;
use App\Http\Requests\StorePaymentSendRequest;
use App\Http\Requests\StorePaymentReceivedRequest;
use App\Http\Requests\UpdatePaymentReceivedRequest;

class PaymentReceivedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PaymentReceived::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentReceivedRequest $request)
    {
        $validated = $request->validated();
        PaymentReceived::create($validated);
        return 'payment received inserted successfully';
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentReceived $paymentReceived)
    {
        return $paymentReceived;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentReceivedRequest $request, PaymentReceived $paymentReceived)
    {
        $validated = $request->validated();
        $paymentReceived->update($validated);
        return 'payment received updated successfully';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentReceived $paymentReceived)
    {
        $paymentReceived->delete();
        return 'PaymentReceived deleted successfully';
    }
}
