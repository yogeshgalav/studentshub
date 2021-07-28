<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MoreAppTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('more_apps')->insert([
            'id'=>1,
            'name'=>'MapCrunch',
            'description'=>'Miss traveling? You’re not alone! This site gives you a random Google map from anywhere in the world and all you have to do is explore.',
            'link'=>'https://www.mapcrunch.com/'
        ],[
            'id'=>2,
            'name'=>'Hacker Typer',
            'description'=>'Want to feel like you’re in The Matrix? Or at least feel like a super cool computer hacker trying to break into some evil lair? Just open up this site and pound the keyboard away!',
            'link'=>'http://hackertyper.com/'
        ],[
            'id'=>3,
            'name'=>'Staggering Beauty',
            'description'=>'Make the virtual worm dance with your mouse when you click on this fun website! Warning: this site does contain flashing images that may trigger some viewers.',
            'link'=>'http://www.staggeringbeauty.com/'
        ],[
            'id'=>4,
            'name'=>'Shady URL',
            'description'=>'Want to play a harmless prank on your friends or give your co-workers a bit of a scare? If you shorten a URL on this website, it will make it look like the URL will lead to a virus or scam site!',
            'link'=>'http://www.shadyurl.com/'
        ],[
            'id'=>5,
            'name'=>'The Useless Web',
            'description'=>'Want to see what the Internet truly has to offer? Take a peek at The Useless Web to see what truly is out there.',
            'link'=>'https://www.theuselessweb.com/'
        ],[
            'id'=>5,
            'name'=>'Stellarium',
            'description'=>'If you live in a big city or an area filled with light pollution, it’s probably been a hot minute since you’ve seen a night sky full of stars. Take a peek at this online planetarium to see which constellations and planets are out tonight!',
            'link'=>'https://stellarium-web.org/'
        ],[
            'id'=>5,
            'name'=>'Don’t Even Reply',
            'description'=>'If you want a good chuckle (or some commiserating validation), check out Don’t Even Reply and read some real-life emails that are side-splittingly funny.',
            'link'=>'http://dontevenreply.com/'
        ],[
            'name'=>'Zoom Quilt',
            'description'=>'If you’re looking to bide some time while having a hypnotizing experience, check out this fun website where a picture infinitely zooms in to create and reveal new pictures.',
            'link'=>'https://zoomquilt.org/'
        ],[
            'name'=>'Freerice',
            'description'=>'Do something good for your soul as you procrastinate! For every correct answer you get on this online vocab quiz, sponsors of Freerice will donate the cash equivalent of 10 grains of rice to the United Nations World Food Programme.',
            'link'=>'https://freerice.com/categories/english-vocabulary'
        ]);
    }
}
