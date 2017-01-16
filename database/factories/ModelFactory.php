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
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'status'         => true,
        'confirm_code'   => str_random(64),
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'name'      => $faker->name,
        'parent_id' => 0,
        'path'      => $faker->url
    ];
});

$factory->define(App\Article::class, function (Faker\Generator $faker) {
    $userId = \App\User::pluck('id')->random();
    $categoryId = \App\Category::pluck('id')->random();
    $title = $faker->sentence(mt_rand(3,10));
    return [
        'user_id'      => $userId,
        'category_id'  => $categoryId,
        'last_user_id' => $userId,
        'slug'     => str_slug($title),
        'title'    => $title,
        'subtitle' => strtolower($title),
        'content'  => $faker->paragraph,
        'image'       => $faker->imageUrl(),
        'description' => $faker->sentence,
        'is_draft'         => false,
        'published_at'     => $faker->dateTimeBetween($startDate = '-2 months', $endDate = 'now')
    ];
});

$factory->define(App\Tag::class, function (Faker\Generator $faker) {
    return [
        'name'              => $faker->word,
    ];
});

$factory->define(App\Article::class, function (Faker\Generator $faker) {
    $tagId = \App\Tag::pluck('id')->random();
    $ArticleId = \App\Article::pluck('id')->random();
    return [
        'tag_id'      => $tagId,
        'article_id'  => $articleId,
    ];
});

$factory->define(App\Link::class, function (Faker\Generator $faker) {
    return [
        'name'  => $faker->name,
        'link'  => $faker->url,
        'image' => $faker->imageUrl()
    ];
});

$factory->define(App\Visitor::class, function (Faker\Generator $faker) {
    $article_id = \App\Article::pluck('id')->random();
    $num = $faker->numberBetween(1, 100);

    $article = App\Article::find($article_id);
    $article->view_count = $num;
    $article->save();

    return [
        'article_id' => $article_id,
        'ip'         => $faker->ipv4,
        'country'    => 'CN',
        'clicks'     => $num
    ];
});
