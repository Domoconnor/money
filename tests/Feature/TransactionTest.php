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
	private $transaction;
	private $other_account;
	private $other_transaction;

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

		$this->transaction = factory(Transaction::class)->create([
			'account_id' => $this->account->id
		]);

		$this->other_transaction = factory(Transaction::class)->create([
			'account_id' => $this->other_account->id
		]);
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

	/**
	 * @test
	 */
	public function user_cannot_delete_others_transactions()
	{
		$this->actingAs($this->other_user);
		$response = $this->json('DELETE', '/api/transaction/' . $this->transaction->id);

		$response->assertStatus(403);
	}

	/**
	 * @test
	 */
	public function user_can_delete_own_transaction()
	{
		$this->actingAs($this->user);
		$response = $this->json('DELETE', '/api/transaction/' . $this->transaction->id);

		$response->assertStatus(200);

		$this->assertDatabaseMissing('transactions', [
			'id' => $this->transaction->id
		]);
	}

	//Edit transaction permissions
	/**
	 * @test
	 */
	public function user_cannot_edit_others_transactions()
	{
		$this->actingAs($this->other_user);
		$response = $this->json('PUT', '/api/transaction/' . $this->transaction->id);

		$response->assertStatus(403);
	}

	/**
	 * @test
	 */
	public function user_can_edit_own_transaction()
	{
		$this->actingAs($this->user);
		$response = $this->json('PUT', '/api/transaction/' . $this->transaction->id, [
			'name' => 'edited',
			'amount' => 1
		]);

		$response->assertStatus(200);

		$this->assertDatabaseHas('transactions', [
			'id' => $this->transaction->id,
			'name' => 'edited',
			'amount' => 1
		]);


	}


}
