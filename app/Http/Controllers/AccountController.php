<?php

namespace App\Http\Controllers;

use App\Account;
use Auth;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

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
    public function store(Request $request)
    {
        $account = new Account($request->all());
        $account->user()->associate(Auth::user());
        try
		{
			$account->save();
		}
		catch (Exception $e)
		{
			return $this->returnError('500', 'Could not save account');
		}

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
		catch (Exception $e)
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

		$account->fill($request->all());
		try
		{
			$account = $account->save();
		}
		catch (Exception $e)
		{
			return $this->returnError('500', 'Could not save Account');
		}


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
			$account->delete();
		}
		catch (Exception $e)
		{
			return $this->returnError('500', 'Could not save Account');
		}
		return $this->returnSuccess();

	}
}
