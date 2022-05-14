<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\MoreApp;

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
        MoreApp::insert(array_reverse([[
            'name'=>'Map Crunch',
            'description'=>'Miss traveling? You’re not alone! This site gives you a random Google map from anywhere in the world and all you have to do is explore.',
            'link'=>'https://www.mapcrunch.com/'
        ],[
            'name'=>'Kick Resume',
            'description'=>'Here you can find lot of resume with respective to job role. The highlighting feature is, this website shows resumes which got selected by mentioned companies. And you can select the same or build new resume for your own.',
            'link'=>'http://kickresume.com/en/'
        ],[
            'name'=>'Auto Draw',
            'description'=>'Convert your drawings to perfect drawing.',
            'link'=>'http://autodraw.com'
        ],[
            'name'=>'Deep Art',
            'description'=>'Turn your photos into a famous art style.',
            'link'=>'http://deepart.io'
        ],[
            'name'=>'Hacker Typer',
            'description'=>'Want to feel like you’re in The Matrix? Or at least feel like a super cool computer hacker trying to break into some evil lair? Just open up this site and pound the keyboard away!',
            'link'=>'http://hackertyper.com/'
        ],[
            'name'=>'Staggering Beauty',
            'description'=>'Make the virtual worm dance with your mouse when you click on this fun website! Warning: this site does contain flashing images that may trigger some viewers.',
            'link'=>'http://www.staggeringbeauty.com/'
        ],[
            'name'=>'Shady URL',
            'description'=>'Want to play a harmless prank on your friends or give your co-workers a bit of a scare? If you shorten a URL on this website, it will make it look like the URL will lead to a virus or scam site!',
            'link'=>'http://www.shadyurl.com/'
        ],[
            'name'=>'The Useless Web',
            'description'=>'Want to see what the Internet truly has to offer? Take a peek at The Useless Web to see what truly is out there.',
            'link'=>'https://www.theuselessweb.com/'
        ],[
            'name'=>'Stellarium',
            'description'=>'If you live in a big city or an area filled with light pollution, it’s probably been a hot minute since you’ve seen a night sky full of stars. Take a peek at this online planetarium to see which constellations and planets are out tonight!',
            'link'=>'https://stellarium-web.org/'
        ],[
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
            'name'=>'Nvidia Inpainting',
            'description'=>'If you ever been photobombed or just want to touch up a picture then you have tot ry this ai tool out. Nvidia found a way to touch up your photos using AI.',
            'link'=>'https://www.nvidia.com/research/inpainting/index.html'
        ],[
            'name'=>'Flight Simulater',
            'description'=>'If you ever wanted to play Microsoft flight simulator but did not have a powerful enough PC to run it then this is the perfect website for you. You can travel around the world with other players on google maps.',
            'link'=>'https://geo-fs.com'
        ],[
            'name'=>'3D lego design',
            'description'=>'You can build the next best lego creation all within your browser. It also has the capability of explorting your design so you can 3D print later!',
            'link'=>'https://mecabricks.com'
        ],[
            'name'=>'EMU OS',
            'description'=>'This website is so nostalgic. You can choose an old OS theme and then play some older pc games within the browser. It also has some useful applications including a code editor.',
            'link'=>'https://emupedia.net/beta/emuos/'
        ],[
            'name'=>'Vocal Remover',
            'description'=>'If you upload a song to this website, it will automatically seperate the vocals and instrumental from the song. You can then adjust the audio on each track.',
            'link'=>'https://vocalremover.org/'
        ],[
            'name'=>'Virtual Vacation',
            'description'=>'This site walks you around a random area in the world and you have to guess where you are just by getting visual clues. So cool if you love to travel!',
            'link'=>'https://virtualvacation.us/'
        ],[
            'name'=>'Room Styler',
            'description'=>"Need help designing the room? This website reminds me all those years playing the sims. It can help you design any room in your house. Also try out floorplanner's website and see which one you like.",
            'link'=>'https://roomstyler.com/'
        ],[
            'name'=>'Google Driving Simulater',
            'description'=>'Drive around the world! This is a cool website to waste some time on. It lets you drive around the world using google maps. What city are you going to pick?',
            'link'=>'https://vocalremover.org/'
        ],[
            'name'=>'LeoLabs Visualization',
            'description'=>'Did you know all this was flying around us? You want belive all the space trash and satellites that are orbiting around the world. Try out this website if you want a visualization of it all.',
            'link'=>'https://vocalremover.org/'
        ],[
            'name'=>'Vo.Codes',
            'description'=>'Did you know you could do this? This website allows you to have a cartoon character and other famous people read out your message using text to speech. It could be used for advertising or marketing purpose maybe.. Or just memes.',
            'link'=>'https://vo.codes/'
        ],[
            'name'=>'Unscreen',
            'description'=>'What are you going to use this website for? Here is a crazy usefull website. It allows you to remove the background of any gif or video. Its perfect for content creators, meme makers and videographers.',
            'link'=>'https://unscreen.com/'
        ],[
            'name'=>'Drive and Listen',
            'description'=>'This site drives you around the famous cities in the world and while driving through you can also listen to current radio at that place. Awsome website if you love to travel!',
            'link'=>'https://driveandlisten.herokuapp.com/'
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
            'name'=>'OnRead',
            'description'=>'If you need a quick and easy book to read, check out OnRead’s library of free ebooks!',
            'link'=>'https://www.onread.com/'
        ],[
            'name'=>'Hippocampus',
            'description'=>'How do you learn? If visual stimuli help you approach your study time better, than Hippocampus may be for you. Free, it contains information and multimedia content on a wide variety of subjects from economics to religion. Visiting the website will give you access to 7,000 videos on all their available subjects. The website also shows you other collections or tools that can further your education.',
            'link'=>'https://www.hippocampus.org/'
        ],[ 
            'name'=>'My Fridge Food ',
            'description'=>'Forget to go food shopping? Don’t worry, just type in whatever is in your fridge into this site and it will create a recipe just for you!',
            'link'=>'https://myfridgefood.com/'
        ],[
            'name'=>'StudentRecipes.com',
            'description'=>'This guide will be a lifesaver throughout student life for times when you’re feeling wrung out, stressed or ill. Whatever your ailments, visit this resource to find out what foods to eat to build your immunity and vitality back up.',
            'link'=>'https://studentrecipes.com/'
        ],[
            'name'=>'Recipepuppy.com',
            'description'=>'RecipePuppy allows you to search for recipes based on the ingredients you already have at home. Lazy students, rejoice.',
            'link'=>'http://www.recipepuppy.com/'
        ],[
            'name'=>'The Ultimate Health Food Guide',
            'description'=>'Exactly what it says on the tin, StudentRecipes.com has recipes for 4,000 quick and easy student meals.',
            'link'=>'http://www.buyagift.co.uk/content/foodhealth/index.html'
        ],[
            'name'=>'Instructables.com',
            'description'=>'This is one of the most useful online student resources if you like making and fixing things yourself. You can learn anything from how to make spaghetti ice-cream to how to fix a broken shelf.',
            'link'=>'https://www.instructables.com/'
        ],[
            'name'=>'KeepMeOut.com',
            'description'=>'If you struggle to stay away from social media when you’re meant to be studying, use KeepMeOut to block certain distracting websites.',
            'link'=>'http://keepmeout.com/en/'
        ],[
            'name'=>'WebMD.com',
            'description'=>'WebMD allows you to check your current health status using its symptom checker. Although this resource is great for hypochondriacs, it doesn’t replace the knowledge of a real doctor – go offline and visit your university’s health center if you’re really concerned.',
            'link'=>'http://www.webmd.com/default.htm'
        ],[
            'name'=>'Genius.com poetry',
            'description'=>'An offshoot of Rap Genius, Lit Genius is a place where scholars have formed a community to annotate poetry and literature, both classic and recent. It’s an extremely helpful resource for English literature students in particular.',
            'link'=>'https://genius.com/tags/poetry'
        ],[
            'name'=>'TED.com',
            'description'=>'TED hosts thought-provoking talks given at events all over the world on the core topics of technology, entertainment and design – but in fact covering pretty much every aspect of human experience. The TED site is where you can find all the videos of these talks. They’re another good procrastination device, but you may also find some inspiration for your next essay.',
            'link'=>'https://www.ted.com/'
        ],[
            'name'=>'Bartleby.com',
            'description'=>'Bartleby publishes classic literature, poetry, non-fiction and reference texts free of charge.',
            'link'=>'http://bartleby.com/'
        ],[
            'name'=>'Gutenberg.org',
            'description'=>'Project Gutenberg provides free online access to texts whose copyright has expired; so far, it’s digitized more than 56,000 texts.',
            'link'=>'https://www.gutenberg.org/'
        ],[
            'name'=>'EdX.org',
            'description'=>'Edx is one of the world’s leading MOOC platforms. MOOCs (massive open online courses) are offered for free to anyone wishing to learn.',
            'link'=>'https://www.edx.org/'
        ],[
            'name'=>'Coursera.org',
            'description'=>'Coursera covers a wide range of academic learning, allowing you to supplement your studies with some additional knowledge.',
            'link'=>'http://www.cousera.org/'
        ],[
            'name'=>'Duolingo',
            'description'=>'Make the most of your free time and cross something off your bucket by becoming fluent in a different language with the help of Duolingo! This fun website also doubles as a fun free app on your phone so you never miss a lesson.',
            'link'=>'https://freerice.com/categories/english-vocabulary'
        ]]));
    }
}
