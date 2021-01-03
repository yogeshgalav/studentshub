<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\ExplorePagePost::class, function (Faker $faker) {
    $user_id=rand(1,50);
    $post_id=rand(1,17);
    // $post=factory(App\Models\Post::class)->create(['user_id'=>$user_id]);
    // $sthub_post=factory(App\Models\SthubPost::class)->create(['post_id'=>$post->id,'shared_by'=>$user_id,'post_type'=>$post->post_type]);
    // factory(App\Models\Like::class)->create(['post_id'=>$post->id,'user_id'=>$user_id]);
    // factory(App\Models\View::class)->create(['post_id'=>$post->id,'user_id'=>$user_id]);
    // factory(App\Models\PostImage::class)->create(['post_id'=>$post->id,'user_id'=>$user_id]);

    // $article=factory(App\Models\Article::class)->create(['post_id'=>$post->id]);
    return [
        'post_id' => $post_id,
        'added_by' => $user_id,
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
        'subject_id'=>rand(1,40),
        'rating'=>$rating
        ];

});

$factory->define(App\Models\Article::class, function (Faker $faker) {
    $content = $faker->sentence(20);
    return [        
        'html_content' => $content,
    ];
});

$factory->define(App\Models\SthubPost::class, function (Faker $faker) {
    return [        
        'post_type'=>'article'
    ];
});
// $factory->define(App\Models\PostSubject::class, function (Faker $faker) {
//     return [        
//         'type'=>'category'
//     ];
// });

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

// $factory->define(App\Models\PostImage::class, function (Faker $faker) {
//     return [        
//         'user_id' => rand(1,40),
//         'path' => (rand(1,10)%2)==0?'/images/slider.jpg':'/images/5.jpg',
//     ];
// });