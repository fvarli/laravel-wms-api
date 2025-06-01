<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Pallet;
use App\Models\Box;
use App\Models\Location;
use App\Models\InventoryMovement;

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

// 1. User Factory
$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'created_at'     => Carbon::now(),
        'updated_at'     => Carbon::now(),
    ];
});

// 2. Pallet Factory
$factory->define(Pallet::class, function (Faker $faker) {
    return [
        'barcode'    => 'PAL' . $faker->unique()->numberBetween(1000, 9999),
        'user_id'    => 1,           // For example, a user ID that already exists in the database
        'status'     => 'OPEN',      // Default enum value
        'created_at'     => Carbon::now(),
        'updated_at'     => Carbon::now(),
    ];
});

// 3. Box Factory
$factory->define(Box::class, function (Faker $faker) {
    return [
        'barcode'    => 'BOX' . $faker->unique()->numberBetween(1000, 9999),
        'pallet_id'  => function () {
            return factory(App\Models\Pallet::class)->create()->id;
        },
        'status'     => 'SCANNED',   // Default enum value
        'created_at'     => Carbon::now(),
        'updated_at'     => Carbon::now(),
    ];
});

// 4. Location Factory
$factory->define(Location::class, function (Faker $faker) {
    return [
        'code'        => 'LOC' . $faker->unique()->numberBetween(1, 999),
        'description' => $faker->sentence(3),
        'created_at'     => Carbon::now(),
        'updated_at'     => Carbon::now(),
    ];
});

// 5. InventoryMovement Factory
$factory->define(InventoryMovement::class, function (Faker $faker) {
    return [
        'box_id'        => function () {
            return factory(App\Models\Box::class)->create()->id;
        },
        'location_id'   => function () {
            return factory(App\Models\Location::class)->create()->id;
        },
        'movement_type' => 'RECEIVE', // Default enum value
        'user_id'       => 1,         // A pre-existing user ID
        'created_at'     => Carbon::now(),
        'updated_at'     => Carbon::now(),
    ];
});