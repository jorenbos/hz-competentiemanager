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
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Competency::class, function (Faker\Generator $faker) {
    return [
        'name'         => $faker->bs,
        'abbreviation' => $faker->bothify('???#'),
        'description'  => $faker->catchPhrase,
        'ec_value'     => $faker->randomElement($array = [2.5, 5.0]),
        'cu_code'      => $faker->bothify('CU#####'),
    ];
});
$factory->define(App\Models\Project::class, function (Faker\Generator $faker) {
    return [
        'name'          => $faker->bs,
        'description'   => $faker->catchPhrase,
        'projectnumber' => $faker->numerify('########'),
    ];
});
$factory->define(App\Models\Student::class, function (Faker\Generator $faker) {
    $gender = $faker->randomElement($array = ['male', 'female']);

    return [
        'name'          => $faker->name($gender),
        'student_code'  => $faker->numerify('000#####'),
        'date_of_birth' => $faker->date('Y-m-d'),
        'starting_date' => $faker->date('Y-m-d'),
        'gender'        => $gender,
    ];
});

$factory->define(App\Models\Slot::class, function (Faker\Generator $faker) {
    return [
        'phase' => '1',
    ];
});

$factory->define(App\Models\Timetable::class, function (Faker\Generator $faker) {
    return [
        'starting_date' => $faker->date('Y-m-d'),
        'end_date'      => $faker->date('Y-m-d'),
    ];
});
