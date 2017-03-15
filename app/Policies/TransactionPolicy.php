<?php

namespace App\Policies;

use App\Account;
use App\User;
use App\Transaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

	public function update(User $user, Transaction $transaction)
	{
		if($user->id === $transaction->account->user->id)
		{
			return true;
		}
		return false;
	}

	public function view(User $user, Account $account)
	{
		if ($user->id === $account->id)
		{
			return true;
		}

		return false;
	}

}
