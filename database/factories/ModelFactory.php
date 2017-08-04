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

$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
    $userId     = \App\Models\User::query()->pluck('id')->random();
    $categoryId = \App\Models\Category::query()->pluck('id')->random();
    $title      = $faker->unique()->realText(mt_rand(10, 30), 5);

    return [
        'title'        => $title,
        'user_id'      => $userId,
        'category_id'  => $categoryId,
        'excerpt'      => $faker->realText(mt_rand(50, 100), 5),
        'content'      => $faker->realText(mt_rand(300, 500), 5),
        'html_content' => $faker->realText(mt_rand(300, 500), 5),
        'image'        => $faker->imageUrl(),
        'slug'         => str_slug($title),
    ];
});

$factory->define(App\Models\Page::class, function (Faker\Generator $faker) {
    $userId = \App\Models\User::pluck('id')->random();
    $title  = $faker->unique()->realText(mt_rand(10, 30), 5);

    return [
        'user_id'      => $userId,
        'title'        => $title,
        'slug'         => str_slug($title),
        'content'      => $faker->realText(mt_rand(300, 500), 5),
        'html_content' => $faker->realText(mt_rand(300, 500), 5),
        'image'        => $faker->imageUrl(),
    ];
});

$factory->define(App\Models\Tag::class, function (Faker\Generator $faker) {
    $name = $faker->unique()->randomElement(['php', 'life', 'technology', 'food', 'laravel']);
    return [
        'name' => $name,
        'slug' => str_slug($name)
    ];
});

$factory->define(App\Models\UploadedFile::class, function (Faker\Generator $faker) {
    $title = $faker->unique()->realText(mt_rand(10, 30), 5);

    return [
        'category_id' => null,
        'title'       => $title,
        'description' => $faker->realText(mt_rand(50, 100), 5),
        'path'        => $faker->imageUrl(),
        'link'        => 'http://' . $faker->domainName(),
        'order'       => 1,
    ];
});
