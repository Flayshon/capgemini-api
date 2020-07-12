<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Account;
use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'account_id' => factory(Account::class),
        'amount' => $faker->numberBetween(1, 5000),
        'description' => $faker->randomElement(['deposit', 'withdraw']),
    ];
});
