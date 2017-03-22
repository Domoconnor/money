<?php

namespace Tests\Feature;

use App\Account;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccountTest extends TestCase
{
	use DatabaseTransactions;

	public function setUp()
	{
		parent::setUp();

		$this->create_users();
	}

	//todo: write view tests

	/**
	 * @test
	 */
	public function user_cannot_create_account_for_other_users()
	{
		$this->actingAs($this->user);
		$response = $this->json('POST', '/api/user/' . $this->other_user->id . "/account");
		$response->assertStatus(403);
	}

	/**
	 * @test
	 */
	public function user_can_create_account()
	{
		$account = factory(Account::class)->make();

		$this->actingAs($this->user);
		$response = $this->json('POST', '/api/user/' . $this->user->id . "/account", ["name" => $account->name]);

		$response
			->assertStatus(200)
			->assertJson([
				'data' => [
				'name' => $account->name
			]]);

		$this->assertDatabaseHas('accounts', [
			'user_id' => $this->user->id,
			'name' => $account->name,
		]);
	}

	/**
	 * @test
	 */
	public function user_cannot_delete_other_users_accounts()
	{
		$this->create_accounts();

		$this->actingAs($this->user);
		$response = $this->json('DELETE', '/api/account/' . $this->other_account->id);

		$response->assertStatus(403);
	}

	/**
	 * @test
	 */
	public function user_can_delete_own_account()
	{
		$this->create_accounts();

		$this->actingAs($this->user);
		$response = $this->json('DELETE', '/api/account/' . $this->account->id);

		$response->assertStatus(200);

		$this->assertDatabaseMissing('accounts', [
			'id' => $this->account->id
		]);
	}

	/**
	 * @test
	 */
	public function user_cannot_update_other_users_accounts()
	{
		$this->create_accounts();

		$this->actingAs($this->user);
		$response = $this->json('put', '/api/account/' . $this->other_account->id);

		$response->assertStatus(403);
	}

	/**
	 * @test
	 */
	public function user_can_update_own_account()
	{
		$this->create_accounts();

		$this->actingAs($this->user);
		$response = $this->json('put', '/api/account/' . $this->account->id, [
			'name' => 'updated'
		]);

		$response->assertStatus(200);

		$this->assertDatabaseHas('accounts',[
			'id' => $this->account->id,
			'name' => 'updated'
		]);
	}
}
