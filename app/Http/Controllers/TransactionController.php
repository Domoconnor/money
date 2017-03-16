<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\StoreTransactionRequest;
use Auth;
use App\Budget;
use App\Account;
use App\Transaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

class TransactionController extends Controller
{

	/**
	 * Returns all the transactions belonging to an account. If nothing is passed in then the logged in user's details
	 * transactions are returned
	 *
	 * @param null|Account $account	The account object to get the list of transactions for
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function index($account = null)
    {
        if($account)
		{
			$this->authorize('view', $account);
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
     * @param  StoreTransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionRequest $request, Account $account)
    {
		$transaction = new Transaction($request->except('budget'));
		$transaction->account()->associate($account);
		$transaction->budget()->associate(Budget::find($request->budget));
		$transaction->save();

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
		catch (ModelNotFoundException $e)
		{
			return $this->returnError('404', 'Transaction not found');
		}

		//Check the user has permission to update this transaction
		$this->authorize('update', $transaction);

		$transaction->fill($request->all());
		$transaction->save();

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
		}
		catch (ModelNotFoundException $e)
		{
			return $this->returnError('404', 'Could not find transaction');
		}

		//Check the user has permission to delete the transaction
		$this->authorize('destroy', $transaction);

    	$transaction->delete();

		return $this->returnSuccess();
    }
}
