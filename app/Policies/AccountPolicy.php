<?php

namespace App\Policies;

use App\User;
use App\Account;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
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

	public function update(User $user, Account $account)
	{
		return $this->allowUser($user, $account);
	}

	public function destroy(User $user, Account $account)
	{
		return $this->allowUser($user, $account);
	}

	/**
	 * Allow a user to do anything to their own account
	 *
	 * @param User $user
	 * @param Account $account
	 * @return bool
	 */
	private function allowUser(User $user, Account $account)
	{
		if($user->id === $account->user->id)
		{
			return true;
		}

		return false;
	}

}
