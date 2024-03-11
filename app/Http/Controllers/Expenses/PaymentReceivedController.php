<?php

namespace App\Http\Controllers;

use App\Models\PaymentSent;
use Illuminate\Http\Request;
use App\Models\PaymentReceived;
use App\Http\Requests\PaymentReceivedRequest;
use App\Http\Requests\StorePaymentSendRequest;
use App\Http\Resources\PaymentReceivedResource;
use App\Http\Requests\StorePaymentReceivedRequest;
use App\Http\Requests\UpdatePaymentReceivedRequest;

class PaymentReceivedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');
        $paymentReceived = PaymentReceived::query()->search($search);
        $paymentReceived = $perPage ? $paymentReceived->latest()->paginate($perPage) : $paymentReceived->latest()->get();
        return PaymentReceivedResource::collection($paymentReceived);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentReceivedRequest $request)
    {
        $paymentReceived = PaymentReceived::create($request->validated());
        return PaymentReceivedResource::make($paymentReceived);
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentReceived $paymentReceived)
    {
        return PaymentReceivedResource::make($paymentReceived);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentReceivedRequest $request, PaymentReceived $paymentReceived)
    {
        $paymentReceived->update($request->validated());
        return PaymentReceivedResource::make($paymentReceived);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentReceived $paymentReceived)
    {
        $paymentReceived->delete();
        return response()->noContent();
    }

    public function bulkDelete(Request $request)
    {
        $paymentReceived = $request->input('paymentReceivedIds');
        PaymentReceived::destroy($paymentReceived);
    }
}
