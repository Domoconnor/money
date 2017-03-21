<?php

namespace Tests;

use App\User;
use App\Account;
use App\Transaction;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

	protected $user;
	protected $other_user;
	protected $account;
	protected $other_account;
	protected $transaction;
	protected $other_transaction;

    public function create_users()
	{
		$this->user = factory(User::class)->create();
		$this->other_user = factory(User::class)->create();
	}

	protected function create_accounts()
	{
		$this->account = factory(Account::class)->create([
			'user_id' => $this->user->id
		]);

		$this->other_account = factory(Account::class)->create([
			'user_id' => $this->other_user->id
		]);
	}

	protected function create_transactions()
	{
		$this->transaction = factory(Transaction::class)->create([
			'account_id' => $this->account->id
		]);

		$this->other_transaction = factory(Transaction::class)->create([
			'account_id' => $this->other_account->id
		]);
	}
}
