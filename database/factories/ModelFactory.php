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

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Competency::class, function(Faker\Generator $faker) {
	return [
		'name' => $faker->bs,
		'abbreviation' => $faker->bothify('???#'),
		'description' => $faker->catchPhrase,
		'ec_value' => $faker->randomElement($array = [2.5, 5.0]),
		'cu_code' => $faker->bothify('CU#####')
	];
});
$factory->define(App\Models\Project::class, function(Faker\Generator $faker) {
	return [
		'name' => $faker->bs,
		'description' => $faker->catchPhrase,
		'projectnumber' => $faker->numerify('########')
	];
});