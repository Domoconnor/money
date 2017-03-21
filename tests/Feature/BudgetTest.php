<?php

namespace Tests\Feature;

use App\Budget;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BudgetTest extends TestCase
{

	use DatabaseTransactions;

	public function setUp()
	{
		parent::setUp();

		$this->create_users();
		$this->create_accounts();

	}


	/**
	 * @test
	 */
	public function user_cannot_create_budget_for_other_user()
	{
		$this->actingAs($this->user);
		$response = $this->json('POST', '/api/user/' . $this->other_user->id . '/budget');
		$response->assertStatus(403);
	}

	/**
	 * @test
	 */
	public function user_can_create_budget()
	{
		$budget = factory(Budget::class)->make();

		$this->actingAs($this->user);
		$response = $this->json('POST', '/api/user/' . $this->user->id . '/budget', ['name' => $budget->name, 'amount' => $budget->amount]);

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
