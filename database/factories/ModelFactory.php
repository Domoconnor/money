<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Account::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->word,
	];
});

$factory->define(App\Transaction::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->word,
		'amount' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 9999.99)
	];
});

$factory->define(App\Budget::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->word,
		'amount' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 9999.99)
	];
});