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
        ],[
            'name'=>'Astronomy Picture of the Day',
            'description'=>'Discover the cosmos from the best of the best with NASA’s astronomy picture of the day! You’ll get to see a stunning photo of space while also learning something with the explorative caption underneath.',
            'link'=>'https://apod.nasa.gov/apod/astropix.html'
        ],[
            'name'=>'MuscleWIki',
            'description'=>'Fine-tune your workout with this fun website, MuscleWiki. It not only gives you a full diagram of the muscles in your body but how to stretch and work them out!',
            'link'=>'https://musclewiki.com/'
        ],[
            'name'=>'Internet Live Stats ',
            'description'=>'You commonly hear the phrase “everyone is on the internet” but how many are there really? Find out how many tweets, Instagram posts, and emails are being sent in real-time!',
            'link'=>'https://www.internetlivestats.com/'
        ],[
            'name'=>'This Is Sand',
            'description'=>'Fine-tune your workout with this fun website, MuscleWiki. It not only gives you a full diagram of the muscles in your body but how to stretch and work them out!',
            'link'=>'https://thisissand.com/'
        ],[
            'name'=>'Radio Garden',
            'description'=>'Ever wanted to hear what the radio was like in Paris or in Tokyo? Travel through the airwaves and see what is playing in local cities (literally any city) in real-time.',
            'link'=>'http://radio.garden/search'
        ],[
            'name'=>'Music Theory',
            'description'=>'Learn the language behind your favorite pieces of music with this fun website! They offer free lessons and exercises so you have all you need to become the next musical genius.',
            'link'=>'https://www.musictheory.net/'
        ],[
            'name'=>'Radiooooo',
            'description'=>'Take a step back into time with Radiooooo. Like the Radio Garden website, you can choose any region in the world and listen to the local airwaves. However, this site gives you a timeline so you can listen to the radio from not just anywhere, but anywhen in time! Have fun listening to 1960s French bops.',
            'link'=>'https://radiooooo.com/'
        ],[
            'name'=>'Sleepytime',
            'description'=>'Did quarantine get your sleeping schedule out of whack? This fun website calculates exactly when you need to go to sleep and wake up in order to get a good night’s sleep.',
            'link'=>'https://sleepyti.me/'
        ],[
            'name'=>'Passive Aggressive Password Machine',
            'description'=>'If you ever wanted to know how strong your password is, simply type it into this machine and it will tell you what you need to work on!',
            'link'=>'https://trypap.com/'
        ],[
            'name'=>'Code Academy ',
            'description'=>'Code Academy offers coding lessons with immediate feedback and real-world projects.',
            'link'=>'https://www.codecademy.com/'
        ],[
            'name'=>'29a.ch',
            'description'=>'Paint the cosmos with all the colors of the wind with this fun interactive creative site! It’s a great and mesmerizing way to relax and chill out after a long day.',
            'link'=>'https://29a.ch/sandbox/2011/neonflames/#'
        ],[
            'name'=>'What Should I Read Next?',
            'description'=>'Read all the books in your library? This website will take your preferences and give you all the book recommendations you could ever want.',
            'link'=>'https://www.whatshouldireadnext.com/'
        ],[
            'name'=>'My Fridge Food ',
            'description'=>'Forget to go food shopping? Don’t worry, just type in whatever is in your fridge into this site and it will create a recipe just for you!',
            'link'=>'https://myfridgefood.com/'
        ],[
            'name'=>'OnRead',
            'description'=>'If you need a quick and easy book to read, check out OnRead’s library of free ebooks!',
            'link'=>'https://www.onread.com/'
        ],[
            'name'=>'Hippocampus',
            'description'=>'How do you learn? If visual stimuli help you approach your study time better, than Hippocampus may be for you. Free, it contains information and multimedia content on a wide variety of subjects from economics to religion. Visiting the website will give you access to 7,000 videos on all their available subjects. The website also shows you other collections or tools that can further your education.',
            'link'=>'https://www.hippocampus.org/'
        ],[
            'name'=>'Duolingo',
            'description'=>'Make the most of your free time and cross something off your bucket by becoming fluent in a different language with the help of Duolingo! This fun website also doubles as a fun free app on your phone so you never miss a lesson.',
            'link'=>'https://freerice.com/categories/english-vocabulary'
        ]);
    }
}
