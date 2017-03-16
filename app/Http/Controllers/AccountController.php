<?php

namespace App\Http\Controllers;

use Auth;
use App\Account;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use App\Http\Requests\StoreAccountRequest;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$accounts = Auth::user()->accounts()->get();
    	foreach ($accounts as &$account)
		{
			$account->sum = $account->getSum();
		}

        return $this->returnSuccess($accounts);
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
    public function store(StoreAccountRequest $request)
    {
        $account = new Account($request->all());
        $account->user()->associate(Auth::user());
		$account->save();

		return $this->returnSuccess($account);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
		{
			$account = Account::findorfail($id);
		}
		catch (ModelNotFoundException $e)
		{
			return $this->returnError('404', 'Account not found');
		}

		$account->sum = $account->getSum();

		return $this->returnSuccess($account);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
			$account = Account::findorfail($id);
		}
		catch (Exception $e)
		{
			return $this->returnError('404', 'Account not found');
		}

		$this->authorize('update', $account);

		$account->fill($request->all());
		$account->save();

		return $this->returnSuccess($account);
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
			$account = Account::findorfail($id);
		}
		catch (ModelNotFoundException $e)
		{
			$this->returnError('404', 'Account not found');
		}

		$account->delete();
		return $this->returnSuccess();

	}
}
