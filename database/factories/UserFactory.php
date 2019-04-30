<?php

use App\Models\User;
use App\Models\Media;
use App\Models\Role;
use App\Models\Region;
use App\Models\Kind;
use App\Models\Album;
use App\Models\Like;
use App\Models\Follow;

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
        'avatar' => $faker->imageUrl(100, 100),
        'gender' => 3,
        'description' => '',
        'role_id' => $faker->randomElement([1, 2]),
        'background' => '',
        'status' => 1,
    ];
});

$factory->define(Album::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'region_id' => Region::all()->random()->id,
        'name' => implode(' ', $faker->words(3)),
        'cover_image' => $faker->imageUrl(640, 480),
        'status' => 1,
        'type' => $faker->randomElement([1, 2]),
        'views' => $faker->numberBetween(100, 10000),
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
        'cover_image' => $faker->imageUrl(640, 300),
        'status' => 1,
        'views' => $faker->numberBetween(100, 10000),
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

$factory->define(Like::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'status' => 1,
    ];
});

$factory->define(Follow::class, function (Faker $faker) {

    $userId = User::all()->random()->id;
    $followId = User::where('id', '!=', $userId)->where('role_id', config('setting.user.role.artist'))->get()->random()->id;

    return [
        'user_id' => $userId,
        'follow_id' => $followId,
    ];
});
