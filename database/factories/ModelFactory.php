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
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Hospital::class, function (Faker\Generator $faker) {
    return [
        'provider_id' => $faker->randomNumber(6),
        'name' => $faker->name(),
        'address' => $faker->streetAddress(),
        'city' => $faker->city(),
        'state' =>  $faker->state(),
        'zipcode' => $faker->postCode(),
        'county' => $faker->city(),
        'phone' => $faker->e164PhoneNumber(),
        'type' => $faker->word(),
        'ownership' => $faker->company(),
        'emergency_services' => $faker->randomElement([true, false]),
        'human_address' => $faker->address(),
        'latitude' => $faker->latitude(),
        'longitude' => $faker->longitude()
    ];
});
