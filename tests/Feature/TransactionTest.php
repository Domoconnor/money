<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Transaction;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TransactionTest extends TestCase
{

	use DatabaseTransactions;

	public function setUp()
	{
		parent::setUp();

		$this->create_users();
		$this->create_accounts();
		$this->create_transactions();
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
