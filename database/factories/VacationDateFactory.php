<?php

use Faker\Generator as Faker;
use Humanity\Entities\Vacation\Models\Vacation;
use Humanity\Entities\User\Models\User;
use Humanity\Entities\Vacation\Models\VacationDate;

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

$factory->define(VacationDate::class, function (Faker $faker) {
    return [
        VacationDate::VACATION_ID => factory(Vacation::class)->create()->{Vacation::ID},
        VacationDate::DATE        => \Carbon\Carbon::now()->addDays(random_int(10, 100))->toDateString()
    ];
});
