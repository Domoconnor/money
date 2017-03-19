<?php

namespace Tests\Feature;

use App\User;
use App\Account;
use Tests\TestCase;
use App\Transaction;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TransactionTest extends TestCase
{

	use DatabaseTransactions;

	private $user;
	private $account;
	private $other_user;
	private $other_account;

	public function setUp()
	{
		parent::setUp();

		$this->user = factory(User::class)->create();
		$this->other_user = factory(User::class)->create();

		$this->account = factory(Account::class)->create([
			'user_id' => $this->user->id
		]);

		$this->other_account = factory(Account::class)->create([
			'user_id' => $this->other_user->id
		]);
	}

	//Create Transaction permissions
	/**
	 * @test
	 */
	public function unauthed_user_cannot_create_transaction()
	{

		$transaction = factory(Transaction::class)->make();
		$response = $this->json('POST', '/api/account/' . $this->account->id . "/transaction", ["name" => $transaction->name, "amount" => $transaction->amount]);
		$response->assertStatus(401);

	}

	/**
	 * @test
	 */
	public function cannot_create_transactions_for_account_owned_by_someone_else()
	{
		$transaction = factory(Transaction::class)->make();

		$this->actingAs($this->other_user);
		$response = $this->json('POST', '/api/account/' . $this->account->id . "/transaction", ["name" => $transaction->name, "amount" => $transaction->amount]);
		$response->assertStatus(403);
	}

	/**
	 * @test
	 */

	public function user_can_create_transactions()
	{
		$transaction = factory(Transaction::class)->make();

		$this->actingAs($this->user);
		$response = $this->json('POST', '/api/account/' . $this->account->id . "/transaction", ["name" => $transaction->name, "amount" => $transaction->amount]);

		$response
			->assertStatus(200)
			->assertJson([
				'data' => [
					'name' => $transaction->name,
					'amount' => $transaction->amount
				]
			]);
	}


	//Delete transaction permissions

	//Edit transaction permissions

	//Show transaction permissions


}
