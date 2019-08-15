<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\ViewPost::class, function (Faker $faker) {
    $post=factory(App\Models\Post::class)->create();
    
    $likes=factory(App\Models\ExplorePost::class)->create(['post_id'=>$post->id]);
    $likes=factory(App\Models\Like::class)->create(['post_id'=>$post->id]);
    $views=factory(App\Models\View::class)->create(['post_id'=>$post->id]);

    $article=factory(App\Models\Article::class)->create(['post_id'=>$post->id]);
    return [
        'post_id' => $post->id,
        'shared_by' => rand(1,40),
    ];
});
$factory->define(App\Models\Post::class, function (Faker $faker) {

    $heading = $faker->sentence(20);
    $rating = $faker->numberBetween(1,5);
    // $post_type=['article','fact','video','link','notice','document'];
    return [
        'user_id'=>rand(1,40),
        'post_type'=>'article',
        'post_heading'=>$heading,
        'rating'=>$rating
        ];

});

$factory->define(App\Models\Article::class, function (Faker $faker) {
    $content = $faker->sentence(20);
    return [        
        'content' => $content,
    ];
});

$factory->define(App\Models\Like::class, function (Faker $faker) {
    $like = $faker->boolean(70);
    return [        
        'user_id' => rand(1,40),
        'like' => $like,
    ];
});

$factory->define(App\Models\View::class, function (Faker $faker) {
    return [        
        'user_id' => rand(1,40),
    ];
});