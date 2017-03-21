<?php

namespace Tests\Feature;

use App\Budget;
use App\User;
use App\Account;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BudgetTest extends TestCase
{
   //Store
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


	/**
	 * @test
	 */
	public function user_cannot_create_budget_for_other_user()
	{
		$this->actingAs($this->user);
		$response = $this->json('POST', '/api/budget');
		$response->assertStatus(403);
	}

	/**
	 * @test
	 */
	public function user_can_create_budget()
	{
		$budget = factory(Budget::class)->make();

		$this->actingAs($this->user);
		$response = $this->json('POST', '/api/budget', ['name' => $budget->name, 'amount' => $budget->amount]);

		$response
			->assertStatus(200)
			->assertJson([
				'data' => [
					'name' => $budget->name,
					'amount' => $budget->amount
				]
			]);

		$this->assertDatabaseHas('budgets', [
			'user_id' => $this->user->id,
			'name' => $budget->name,
			'amount' => $budget->amount
		]);
	}
}
