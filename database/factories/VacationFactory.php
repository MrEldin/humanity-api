<?php

use Faker\Generator as Faker;
use Humanity\Entities\Vacation\Models\Vacation;
use Humanity\Entities\User\Models\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Vacation::class, function (Faker $faker) {
    return [
        Vacation::USER_ID => factory(User::class)->create()->{User::ID},
        Vacation::NAME    => $faker->word
    ];
});
