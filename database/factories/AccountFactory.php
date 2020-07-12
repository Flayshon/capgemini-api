<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Account;
use App\User;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'number' => $faker->bankAccountNumber,
        'balance' => $faker->numberBetween(1, 5000)
    ];
});
