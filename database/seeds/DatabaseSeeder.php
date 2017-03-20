<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$user = factory(App\User::class)->create([
			'name' => "Test McTest",
       		'email' => "test@test.com",
		]);
    }
}
