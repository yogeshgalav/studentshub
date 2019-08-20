<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\ExplorePagePost::class, function (Faker $faker) {
    $user_id=rand(1,50);
    $post=factory(App\Models\Post::class)->create(['user_id'=>$user_id]);
    factory(App\Models\PostSubject::class)->create(['post_id'=>$post->id,'subject_id'=>1,'type'=>'category']);
    factory(App\Models\PostSubject::class)->create(['post_id'=>$post->id,'subject_id'=>2,'type'=>'branch_subject']);
    factory(App\Models\ViewPost::class)->create(['post_id'=>$post->id,'shared_by'=>$user_id,'post_type'=>$post->post_type]);
    factory(App\Models\Like::class)->create(['post_id'=>$post->id,'user_id'=>$user_id]);
    factory(App\Models\View::class)->create(['post_id'=>$post->id,'user_id'=>$user_id]);

    $article=factory(App\Models\Article::class)->create(['post_id'=>$post->id]);
    return [
        'post_id' => $post->id,
        'added_by' => 1,
    ];
});
$factory->define(App\Models\Post::class, function (Faker $faker) {

    // $heading = $faker->sentence(20);
    $heading = 'Best Design Resources This Week';
    $rating = $faker->numberBetween(1,5);
    // $post_type=['article','fact','video','link','notice','document'];
    return [
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

$factory->define(App\Models\ViewPost::class, function (Faker $faker) {
    return [        
        'post_type'=>'article'
    ];
});
$factory->define(App\Models\PostSubject::class, function (Faker $faker) {
    return [        
        'type'=>'category'
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