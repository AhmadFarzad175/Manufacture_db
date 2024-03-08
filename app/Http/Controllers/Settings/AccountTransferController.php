<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Models\Settings\Account;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Settings\AccountTransfer;
use App\Http\Requests\Settings\AccountTransferRequest;


class AccountTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountTransferRequest $request)
    {
        try {
            // Validate the request using the TransferRequest rules
            $validatedData = $request->validated();

            // Use a database transaction to ensure data integrity
            DB::beginTransaction();

            // Check if from_account has sufficient balance
            $fromAccount = Account::find($validatedData['from_account_id']);
            if ($fromAccount->price < $validatedData['from_amount']) {
                throw new \Exception('Insufficient funds in from_account');
            }

            // Update account balances using decrement and increment
            Account::where('id', $validatedData['from_account_id'])->decrement('price', $validatedData['from_amount']);
            Account::where('id', $validatedData['to_account_id'])->increment('price', $validatedData['to_amount']);

            // Create a new transfer record
            $transfer = AccountTransfer::create([
                'from_account_id' => $validatedData['from_account_id'],
                'to_account_id' => $validatedData['to_account_id'],
                'user_id' => $validatedData['user_id'],
                'from_amount' => $validatedData['from_amount'],
                'to_amount' => $validatedData['to_amount'],
                'date' => $validatedData['date'],
            ]);

            // Commit the transaction
            DB::commit();

            // You can return a response, redirect, or perform any other action here
            return response()->json(['message' => 'Transfer record created successfully', 'data' => $transfer], 201);
        } catch (\Exception $e) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountTransfer $accountTransfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountTransfer $accountTransfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountTransfer $accountTransfer)
    {
        //
    }
}
