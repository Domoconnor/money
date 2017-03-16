<?php

namespace App\Policies;

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
		return $this->allowUser($user, $transaction);
	}


	public function destroy(User $user, Transaction $transaction)
	{
		return $this->allowUser($user, $transaction);

	}

	/**
	 * Allow a user to do anything to their own transactions
	 *
	 * @param User $user
	 * @param Transaction $transaction
	 * @return bool
	 */
	private function allowUser(User $user, Transaction $transaction)
	{
		if($user->id === $transaction->account->user->id)
		{
			return true;
		}

		return false;
	}

}
