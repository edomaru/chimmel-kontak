<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Contact;
use App\Company;
use Faker\Generator as Faker;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
        'address' => $faker->address,
        //'company_id' => Company::pluck('id')->random()
    ];
});
