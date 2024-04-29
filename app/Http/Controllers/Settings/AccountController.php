<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Models\Settings\Account;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\AccountRequest;
use App\Http\Resources\Settings\AccountResource;


class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        // Eager load relationships and apply search
        $accounts = Account::query()->search($search);

        $accounts = $perPage ? $accounts->latest()->paginate($perPage) : $accounts->latest()->get();

        return AccountResource::collection($accounts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountRequest $request)
    {
        Account::create($request->validated());
        return response()->json(['success', 'Account created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        return AccountResource::make($account);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccountRequest $request, Account $account)
    {
        $account->update($request->validated());
        return response()->json(['success', 'Account updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        $account->delete();
        return response()->json(['success', 'Account deleted successfully']);
    }


    public function bulkDelete(Request $request)
    {
        $accounts = $request->input('accountIds');
        Account::destroy($accounts);
        return response()->json(['success', 'Accounts deleted successfully']);
    }
}
