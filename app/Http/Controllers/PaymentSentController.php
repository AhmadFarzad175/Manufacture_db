<?php

namespace App\Http\Controllers;

use App\Models\PaymentSend;
use App\Models\PaymentSent;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentSentRequest;
use App\Http\Resources\PaymentSentResource;
use App\Http\Requests\StorePaymentSendRequest;
use App\Http\Requests\UpdatePaymentSendRequest;

class PaymentSentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PaymentSentResource(PaymentSent::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentSentRequest $request)
    {
        $validated = $request->validated();
        PaymentSend::create($validated);
        return 'payment inserted successfully';
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentSend $paymentSend)
    {
        return $paymentSend;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentSentRequest $request, PaymentSend $paymentSend)
    {
        $validated = $request->validated();
        $paymentSend->update($validated);
        return 'payment updated successfully';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentSend $paymentSend)
    {
        $paymentSend->delete();
        return 'payment send deleted successfully';
    }
}
