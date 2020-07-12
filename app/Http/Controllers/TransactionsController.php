<?php

namespace App\Http\Controllers;

use DB;
use App\Account;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $account = Account::firstWhere('number', $request->input('number'));
        if (!$account) {
            return response()->json(['error' => 'Account not found.'], 404);
        }

        $transactionAmount = $request->input(('amount')) * 100;

        DB::beginTransaction();

        try {
            Transaction::create([
                'account_id' => $account->id,
                'amount' => $transactionAmount,
                'description' => $request->input('description')
            ]);
    
            if ($request->input('description') == 'deposit') {
                $account->balance += $transactionAmount;
            } else if ($request->input('description') == 'withdraw') {
                $account->balance -= $transactionAmount;
            } else {
                return response()->json(['error' => 'Invalid operation.'], 422);
            }
    
            $account->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }

        return response()->json(['message' => 'Transaction saved.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
