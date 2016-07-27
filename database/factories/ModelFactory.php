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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->email,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Article::class, function (Faker\Generator $faker) {
    return [
        'title'   => implode(' ', $faker->words),
        'chapeau' => $faker->paragraph,
        'content' => implode('\n', $faker->paragraphs),
        'issue_id' => factory(App\Issue::class)->create()->id,
        'reads'    => $faker->numberBetween(0, 3680),
    ];
});

$factory->define(App\Issue::class, function (Faker\Generator $faker) {
    return [
        'published_at'      => $faker->unique()->dateTimeThisYear('+1 month')->format('d/m/Y'),
        'number'            => $faker->unique()->numberBetween(1, 345),
        'editorial_content' => implode('\n', $faker->paragraphs),
        'editorial_title'   => $faker->sentence,
        'masthead'          => $faker->optional()->paragraph,
    ];
});

$factory->define(App\Friend::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'url'  => $faker->url,
    ];
});

$factory->define(App\Location::class, function (Faker\Generator $faker) {
    return [
        'name'        => implode(' ', $faker->words),
        'city'        => $faker->city,
        'longitude'   => $faker->randomFloat(2, 5.7, 5.9),
        'latitude'    => $faker->randomFloat(2, 45.40, 45.70),
        'description' => $faker->optional()->paragraph,
    ];
});

$factory->define(App\Page::class, function (Faker\Generator $faker) {
    return [
        'title'             => implode(' ', $faker->words),
        'content'           => implode('\n', $faker->paragraphs),
        'display_in_menu'   => $faker->boolean,
        'display_in_footer' => $faker->boolean,
    ];
});