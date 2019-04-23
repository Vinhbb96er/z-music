<?php

use App\Models\User;
use App\Models\Media;
use App\Models\Role;
use App\Models\Region;
use App\Models\Kind;
use App\Models\Album;

use Illuminate\Support\Str;
use Faker\Generator as Faker;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'avatar' => '',
        'gender' => 3,
        'description' => '',
        'role_id' => 2,
        'background' => '',
        'status' => 1,
    ];
});

$factory->define(Album::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'region_id' => Region::all()->random()->id,
        'name' => implode(' ', $faker->words(3)),
        'cover_image' => '',
        'status' => 1,
    ];
});

$factory->define(Media::class, function (Faker $faker) {
    return [
        'album_id' => Album::all()->random()->id,
        'region_id' => Region::all()->random()->id,
        'user_id' => User::all()->random()->id,
        'url' => '',
        'name' => implode(' ', $faker->words(3)),
        'type' => $faker->randomElement([1, 2]),
        'lyrics' => '',
        'artist_name' => User::all()->random()->name,
        'cover_image' => '',
        'status' => 1,
    ];
});

$factory->define(Role::class, function (Faker $faker) {
    return [];
});

$factory->define(Region::class, function (Faker $faker) {
    return [];
});

$factory->define(Kind::class, function (Faker $faker) {
    return [];
});
