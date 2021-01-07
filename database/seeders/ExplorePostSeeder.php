<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ExplorePagePost;
class ExplorePostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::statement("INSERT INTO posts (user_id,subject_id,postable_id,postable_type,post_heading,primary_image_path,rating,created_at,updated_at,post_description) VALUES
            (1,42,1,'App\Models\Video','The iPhone Documentary - The Untold Story','https://img.youtube.com/vi/24O00Jz8R04/0.jpg',3,'2019-11-03 09:01:25.0','2020-02-20 15:53:20.0','The iPhone Documentary - The Untold Story'),
            (1,43,2,'App\Models\Video','The Egg','https://img.youtube.com/vi/h6fcK_fRYaI/0.jpg',3,'2019-11-03 09:25:21.0','2020-02-20 15:53:20.0','The Egg'),
            (1,44,3,'App\Models\Video','Why Finding an Alien Life Would be our Doom?','https://img.youtube.com/vi/UjtOGPJ0URM/0.jpg',3,'2019-11-03 09:27:29.0','2020-02-20 15:53:20.0','Finding alien life on a distant planet would be amazing news - or would it? If we are not the only intelligent life in the universe, this probably means our days are numbered and doom is certain.'),
            (1,45,4,'App\Models\Video','How to start a business with no money: tips for entrepreneurs','https://img.youtube.com/vi/jD0WQW_-O8k/0.jpg',3,'2019-11-03 09:41:22.0','2020-02-20 15:53:20.0','How to start a business with no money: tips for entrepreneurs'),
            (1,47,5,'App\Models\Video','How to Create a Pitch Deck for Investors: Fundraising for Startups','https://img.youtube.com/vi/SB16xgtFmco/0.jpg',3,'2019-11-03 11:04:12.0','2020-02-20 15:53:20.0',NULL),
            (1,46,6,'App\Models\Video','Seed Funding for Startups: How to raise venture capital as an entrepreneur','https://img.youtube.com/vi/4RAs9Y5wwDo/0.jpg',3,'2019-11-03 11:16:29.0','2020-02-20 15:53:20.0','Raising money is hard. It\'s so hard most companies fail at it. \nIn this video, we\'ll look into traction requirements, pitch decks, alternative funding sources and on how to find investors. This is seed funding for entrepreneurs. \n\nI\'m the CEO of a company called Slidebean, and thousands of startups have used our platform to create their pitch decks. Their success is our success, and this is why we get involved with them and have learned a thing or to about what works, and what doesn\'t. \n\nI started my first company in 2011, and I failed at raising capital. I know the pain of shutting down a website you spent countless hours on, and having to email all your customers to say it\'s game over. \n\nThe problem with my first company is that we spent too much time trying to find investors, hence we failed to notice some of the fundamental flaws in our product. \n\nFor Slidebean, we raised a seed round of $800,000 which has allowed us to grow to a team of 25, increase our revenue to seven digits and become profitable in the process. And yeah, it was hard. \nI\'m telling you this because I want you to trust my advice. I tried and failed, and I can look back and see why I got a \'NO\' from most of the 142 investors I pitched. Yeah, 142 to raise $800,000. \n\nSo let\'s talk about traction, first. \n\nI have this problem with startup press (but we love YOU, @jordanrcrook). It gives new founders a false notion of how fundraising works. You read the story of Yo, an app that just sent notifications saying \'Yo\' and how they raised a $1,000,000 seed round, and you assume that\'s something anyone with a couple of lines of code can do. \n\nMost companies raise money AFTER getting traction. Very few companies raise money with just a prototype and no users, and certainly, NO company raises money without a fully formed founding team. \n\nThe most extreme case here is tech companies that are trying to raise money to hire a CTO. This makes no sense. Tech talent is expensive, and it\'s scarce, and the first proof that your company is worth something is that you managed to find a full stack developer that would turn down a job at Google to work on this idea. As a CEO, you need to be able to find and convince that guy, who joins your company for the stock and not for the salary; when he could be making $150,000/yr otherwise.\nThe reality of startup fundraising today, at least in Silicon Valley and New York, is that companies are pitching investors with traction, excellent traction. \n\nTraction usually comes in the form of revenue: tens of thousands of dollars per month, growing over +20% month-over-month. I\'m not making this up, check this article by VC Elizabeth Yin. Pure play, no-revenue traction counts only when you are dealing with millions of users and fantastic retention rates. \n\nSo how can you get to these numbers venture capitalists expect, if you don\'t have any money to start with? Yeah well, bootstrapping. \nWe bought our domain in 2013 and started working on our product, but it was only after 18 months that we managed to get any decent money to ramp up growth. It was $100,000 from the 500 Startups program, but we\'ll talk about accelerators in a minute. \n\nFrom May 2013 through October 2014 we bootstrapped. We did part-time consulting so we could pay our bills. We had a $1,000 salary each, and we shared an apartment. It was barely enough, but the backgrounds of the three founders made up for all the talent we needed: no need to hire anyone. Our company burn rate was probably $3,500 including our \'salaries\' and the services we needed. \n#seedfunding #startups #venturecapital'),
            (1,50,9,'App\Models\Video','Does the fly sitting on your food make you sick?','https://img.youtube.com/vi/-zf7UxfL0zE/0.jpg',3,'2019-11-03 12:03:43.0','2020-02-20 15:53:20.0','Have you ever wondered what a fly is doing when it lands on your food?\n“Answer this question while you are not eating: Which of the following would make you stop chowing down if you spied them while you were in a restaurant?”'),
            (1,51,10,'App\Models\Video','What Happens When You Die?','https://img.youtube.com/vi/nqOITqLfnkc/0.jpg',3,'2019-11-03 12:06:17.0','2020-02-20 15:53:20.0','mmediately after you die, your body begins to decompose. Trace thought it would be interesting to take a look at everything that happens after your heart stops beating.\n“A study of seven terminally ill patients found identical surges in brain activity moments before death, providing what may be physiological evidence of ‘out of body’ experiences reported by people who survive near-death ordeals.”'),
            (1,52,11,'App\Models\Video','Consciousness: Crash Course Psychology','https://img.youtube.com/vi/jReX7qKU2yc/0.jpg',3,'2019-11-03 12:14:53.0','2020-02-20 15:53:20.0','Consciousness: Crash Course Psychology'),
            (1,53,12,'App\Models\Video','Intro to Psychology: Crash Course Psychology','https://img.youtube.com/vi/vo4pMVb0R6M/0.jpg',3,'2019-11-03 12:16:05.0','2020-02-20 15:53:20.0','Intro to Psychology: Crash Course Psychology');");
            
            DB::statement("INSERT INTO posts (user_id,subject_id,postable_id,postable_type,post_heading,primary_image_path,rating,created_at,updated_at,post_description) VALUES
            (1,54,13,'App\Models\Video','Why Do We Dream?','https://img.youtube.com/vi/7GGzc3x9WJU/0.jpg',3,'2019-11-03 12:17:16.0','2020-02-20 15:53:20.0','Why Do We Dream?'),
            (1,51,14,'App\Models\Video','How Much Pain Can You Handle?','https://img.youtube.com/vi/s4XQo4txlk0/0.jpg',3,'2019-11-03 12:20:59.0','2020-02-20 15:53:20.0','How Much Pain Can You Handle?'),
            (1,44,15,'App\Models\Video','Which Came First - The Chicken or the Egg?','https://img.youtube.com/vi/1a8pI65emDE/0.jpg',3,'2019-11-03 12:26:31.0','2020-02-20 15:53:20.0','Which Came First - The Chicken or the Egg?'),
            (1,57,17,'App\Models\Video','How Much Sleep Do You Actually Need?','https://img.youtube.com/vi/SVQlcxiQlzI/0.jpg',3,'2019-11-03 12:40:07.0','2020-02-20 15:53:20.0','How Much Sleep Do You Actually Need?'),
            (1,58,18,'App\Models\Video','What if We ARE Alone in the Universe?','https://img.youtube.com/vi/c9TXy_Ovweg/0.jpg',3,'2019-11-03 12:43:41.0','2020-02-20 15:53:20.0','What if We ARE Alone in the Universe?'),
            (1,59,19,'App\Models\Video','How An Igloo Keeps You Warm?','https://img.youtube.com/vi/1L7EI0vKVuU/0.jpg',3,'2019-11-03 12:46:24.0','2020-02-20 15:53:20.0','How An Igloo Keeps You Warm?'),
            (1,44,20,'App\Models\Video','Why Are We The Only Humans Left?','https://img.youtube.com/vi/dbHj-Q1FTj8/0.jpg',3,'2019-11-03 12:48:39.0','2020-02-20 15:53:20.0','Why Are We The Only Humans Left?');");
            
            DB::statement("INSERT INTO videos (video_id,created_at,updated_at) VALUES
            ('24O00Jz8R04',NULL,NULL),
            ('h6fcK_fRYaI',NULL,NULL),
            ('UjtOGPJ0URM',NULL,NULL),
            ('jD0WQW_-O8k',NULL,NULL),
            ('SB16xgtFmco',NULL,NULL),
            ('4RAs9Y5wwDo',NULL,NULL),
            ('-zf7UxfL0zE',NULL,NULL),
            ('nqOITqLfnkc',NULL,NULL),
            ('jReX7qKU2yc',NULL,NULL),
            ('vo4pMVb0R6M',NULL,NULL),
            ('7GGzc3x9WJU',NULL,NULL),
            ('s4XQo4txlk0',NULL,NULL),
            ('1a8pI65emDE',NULL,NULL),
            ('SVQlcxiQlzI',NULL,NULL),
            ('c9TXy_Ovweg',NULL,NULL),
            ('1L7EI0vKVuU',NULL,NULL),
            ('dbHj-Q1FTj8',NULL,NULL);");

            DB::statement("INSERT INTO `sthub_posts` (`id`, `post_id`, `shared_by`, `classroom_id`, `batch_id`, `course_id`, `institute_id`, `created_at`, `updated_at`) VALUES
            (1, 1, 1,  NULL, NULL, NULL, 1, '2019-11-03 20:01:25', '2019-11-03 20:01:25'),
            (2, 2, 1,  NULL, NULL, NULL, 1, '2019-11-03 20:25:21', '2019-11-03 20:25:21'),
            (3, 3, 1,  NULL, NULL, NULL, 1, '2019-11-03 20:27:29', '2019-11-03 20:27:29'),
            (4, 4, 1,  NULL, NULL, NULL, 1, '2019-11-03 20:41:22', '2019-11-03 20:41:22'),
            (5, 5, 1,  NULL, NULL, NULL, 1, '2019-11-03 22:04:12', '2019-11-03 22:04:12'),
            (6, 6, 1,  NULL, NULL, NULL, 1, '2019-11-03 22:16:29', '2019-11-03 22:16:29'),
            (7, 7, 1,  NULL, NULL, NULL, 1, '2019-11-03 23:03:43', '2019-11-03 23:03:43'),
            (8, 8, 1,  NULL, NULL, NULL, 1, '2019-11-03 23:06:17', '2019-11-03 23:06:17'),
            (9, 9, 1,  NULL, NULL, NULL, 1, '2019-11-03 23:14:53', '2019-11-03 23:14:53'),
            (10, 10, 1,  NULL, NULL, NULL, 1, '2019-11-03 23:16:05', '2019-11-03 23:16:05'),
            (11, 11, 1,  NULL, NULL, NULL, 1, '2019-11-03 23:17:16', '2019-11-03 23:17:16'),
            (12, 12, 1,  NULL, NULL, NULL, 1, '2019-11-03 23:21:00', '2019-11-03 23:21:00'),
            (13, 13, 1,  NULL, NULL, NULL, 1, '2019-11-03 23:26:31', '2019-11-03 23:26:31'),
            (14, 14, 1,  NULL, NULL, NULL, 1, '2019-11-03 23:40:07', '2019-11-03 23:40:07'),
            (15, 15, 1,  NULL, NULL, NULL, 1, '2019-11-03 23:43:41', '2019-11-03 23:43:41'),
            (16, 16, 1,  NULL, NULL, NULL, 1, '2019-11-03 23:46:24', '2019-11-03 23:46:24'),
            (17, 17, 1,  NULL, NULL, NULL, 1, '2019-11-03 23:48:39', '2019-11-03 23:48:39');");


        DB::statement("INSERT INTO `subjects` (`id`, `Subject_name`, `subject_url`, `category_id`, `created_at`, `updated_at`) VALUES
        (42, 'Iphone', 'iphone',1, NULL, NULL),
        (43, 'Atheist', 'atheist',10, NULL, NULL),
        (44, 'Evolution', 'evolution',5, NULL, NULL),
        (45, 'Startup', 'startup',2, NULL, NULL),
        (47, 'Pitch Deck', 'pitch-deck',2, NULL, NULL),
        (46, 'Seed funding', 'seed-funding',2, NULL, NULL),
        (48, 'Sex', 'sex',3, NULL, NULL),
        (49, 'Weed', 'weed',5, NULL, NULL),
        (50, 'Disease', 'disease',3, NULL, NULL),
        (51, 'Human Body', 'human-body',3, NULL, NULL),
        (52, 'Consciousness', 'consciousness',10, NULL, NULL),
        (53, 'Psychology', 'psychology',10, NULL, NULL),
        (54, 'Human Brain', 'Human Brain',5, NULL, NULL),
        (56, 'Masturbation', 'Masturbation',3, NULL, NULL),
        (57, 'Sleep', 'sleep',5, NULL, NULL),
        (58, 'Universe', 'universe',5, NULL, NULL),
        (59, 'Igloo', 'igloo',5, NULL, NULL);");

        // ExplorePagePost::factory(3)->create(['page_section'=>'ExploreTopPost']);
        // ExplorePagePost::factory(6)->create(['page_section'=>'HomePostContainer']);
        // ExplorePagePost::factory(3)->create(['page_section'=>'ExploreSidebar']);
        // ExplorePagePost::factory(3)->create(['page_section'=>'ExploreBottomPost']);
    }
}
