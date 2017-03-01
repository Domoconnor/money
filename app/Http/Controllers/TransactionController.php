<?php

namespace App\Http\Controllers;
use Auth;
use App\Budget;
use App\Account;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($account = null)
    {
        if($account)
		{
			return $this->returnSuccess(Account::findorfail($account)->transactions()->get());
		}
		return $this->returnSuccess(Auth::user()->transactions()->get());


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
    public function store(Request $request, $account)
    {
		$transaction = new Transaction($request->except('budget'));
		$transaction->account()->associate($account);
		$transaction->budget()->associate(Budget::find($request->budget));
		try
		{
			$transaction->save();
		}
		catch (Exception $e)
		{
			return $this->returnError('500', 'Could create the transaction');
		}

		return $this->returnSuccess($transaction);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		try
		{
			$transaction = Transaction::findorfail($id);
		}
		catch (Exception $e)
		{
			return $this->returnError('404', 'Transaction not found');
		}

		$transaction->fill($request->all());

		try
		{
			$transaction->save();
		}
		catch (Exception $e)
		{
			return $this->returnError('500', 'Could not save transaction');
		}

		return $this->returnSuccess($transaction);
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		try
		{
			$transaction = Transaction::findorfail($id);
			$transaction->delete();
		}
		catch (Exception $e)
		{
			return $this->returnError('500', 'Could not delete transaction');
		}
		return $this->returnSuccess();
    }
}
