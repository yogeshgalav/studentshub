<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExplorePostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            // factory(\App\Models\ExplorePagePost::class,3)->create(['page_section'=>'ExploreCarousalPost']);
            // factory(\App\Models\ExplorePagePost::class,3)->create(['page_section'=>'ExploreTopPost']);
            // factory(\App\Models\ExplorePagePost::class,6)->create(['page_section'=>'HomePostContainer']);
            // factory(\App\Models\ExplorePagePost::class,3)->create(['page_section'=>'ExploreSidebar']);
            // factory(\App\Models\ExplorePagePost::class,3)->create(['page_section'=>'ExploreBottomPost']);
            DB::statement("INSERT INTO `posts` (`id`, `user_id`, `subject_id`, `postable_id`, `postable_type`, `post_heading`, `primary_image_path`, `post_url`, `rating`, `created_at`, `updated_at`) VALUES
            (1, 1, 42, 1, 'App\\\\Models\\\\Video', 'The iPhone Documentary - The Untold Story', 'https://img.youtube.com/vi/24O00Jz8R04/0.jpg', NULL, 3, '2019-11-03 09:01:25', '2020-02-20 15:53:20'),
            (2, 1, 43, 2, 'App\\\\Models\\\\Video', 'The Egg', 'https://img.youtube.com/vi/h6fcK_fRYaI/0.jpg', NULL, 3, '2019-11-03 09:25:21', '2020-02-20 15:53:20'),
            (3, 1, 44, 3, 'App\\\\Models\\\\Video', 'Why Finding an Alien Life Would be our Doom?', 'https://img.youtube.com/vi/UjtOGPJ0URM/0.jpg', NULL, 3, '2019-11-03 09:27:29', '2020-02-20 15:53:20'),
            (4, 1, 45, 4, 'App\\\\Models\\\\Video', 'How to start a business with no money: tips for entrepreneurs', 'https://img.youtube.com/vi/jD0WQW_-O8k/0.jpg', NULL, 3, '2019-11-03 09:41:22', '2020-02-20 15:53:20'),
            (5, 1, 47, 5, 'App\\\\Models\\\\Video', 'How to Create a Pitch Deck for Investors: Fundraising for Startups', 'https://img.youtube.com/vi/SB16xgtFmco/0.jpg', NULL, 3, '2019-11-03 11:04:12', '2020-02-20 15:53:20'),
            (6, 1, 46, 6, 'App\\\\Models\\\\Video', 'Seed Funding for Startups: How to raise venture capital as an entrepreneur', 'https://img.youtube.com/vi/4RAs9Y5wwDo/0.jpg', NULL, 3, '2019-11-03 11:16:29', '2020-02-20 15:53:20'),
            (7, 1, 48, 7, 'App\\\\Models\\\\Video', 'Why Do We Have Sex?', 'https://img.youtube.com/vi/rTFqo81Ci_0/0.jpg', NULL, 3, '2019-11-03 11:28:43', '2020-02-20 15:53:20'),
            (8, 1, 49, 8, 'App\\\\Models\\\\Video', 'Is marijuana less harmfull in comparison to other drugs?', 'https://img.youtube.com/vi/JsUoG2DZ_S8/0.jpg', NULL, 3, '2019-11-03 11:36:08', '2020-02-20 15:53:20'),
            (9, 1, 50, 9, 'App\\\\Models\\\\Video', 'Does the fly sitting on your food make you sick?', 'https://img.youtube.com/vi/-zf7UxfL0zE/0.jpg', NULL, 3, '2019-11-03 12:03:43', '2020-02-20 15:53:20'),
            (10, 1, 51, 10, 'App\\\\Models\\\\Video', 'What Happens When You Die?', 'https://img.youtube.com/vi/nqOITqLfnkc/0.jpg', NULL, 3, '2019-11-03 12:06:17', '2020-02-20 15:53:20'),
            (11, 1, 52, 11, 'App\\\\Models\\\\Video', 'Consciousness: Crash Course Psychology', 'https://img.youtube.com/vi/jReX7qKU2yc/0.jpg', NULL, 3, '2019-11-03 12:14:53', '2020-02-20 15:53:20'),
            (12, 1, 53, 12, 'App\\\\Models\\\\Video', 'Intro to Psychology: Crash Course Psychology', 'https://img.youtube.com/vi/vo4pMVb0R6M/0.jpg', NULL, 3, '2019-11-03 12:16:05', '2020-02-20 15:53:20'),
            (13, 1, 54, 13, 'App\\\\Models\\\\Video', 'Why Do We Dream?', 'https://img.youtube.com/vi/7GGzc3x9WJU/0.jpg', NULL, 3, '2019-11-03 12:17:16', '2020-02-20 15:53:20'),
            (14, 1, 51, 14, 'App\\\\Models\\\\Video', 'How Much Pain Can You Handle?', 'https://img.youtube.com/vi/s4XQo4txlk0/0.jpg', NULL, 3, '2019-11-03 12:20:59', '2020-02-20 15:53:20'),
            (15, 1, 44, 15, 'App\\\\Models\\\\Video', 'Which Came First - The Chicken or the Egg?', 'https://img.youtube.com/vi/1a8pI65emDE/0.jpg', NULL, 3, '2019-11-03 12:26:31', '2020-02-20 15:53:20'),
            (16, 1, 56, 16, 'App\\\\Models\\\\Video', 'Is Masturbation Good For You?', 'https://img.youtube.com/vi/GU3JqoUDkjA/0.jpg', NULL, 3, '2019-11-03 12:33:58', '2020-02-20 15:53:20'),
            (17, 1, 57, 17, 'App\\\\Models\\\\Video', 'How Much Sleep Do You Actually Need?', 'https://img.youtube.com/vi/SVQlcxiQlzI/0.jpg', NULL, 3, '2019-11-03 12:40:07', '2020-02-20 15:53:20'),
            (18, 1, 58, 18, 'App\\\\Models\\\\Video', 'What if We ARE Alone in the Universe?', 'https://img.youtube.com/vi/c9TXy_Ovweg/0.jpg', NULL, 3, '2019-11-03 12:43:41', '2020-02-20 15:53:20'),
            (19, 1, 59, 19, 'App\\\\Models\\\\Video', 'How An Igloo Keeps You Warm?', 'https://img.youtube.com/vi/1L7EI0vKVuU/0.jpg', NULL, 3, '2019-11-03 12:46:24', '2020-02-20 15:53:20'),
            (20, 1, 44, 20, 'App\\\\Models\\\\Video', 'Why Are We The Only Humans Left?', 'https://img.youtube.com/vi/dbHj-Q1FTj8/0.jpg', NULL, 3, '2019-11-03 12:48:39', '2020-02-20 15:53:20');");
            
            DB::statement("INSERT INTO `videos` (`id`, `link`, `content`, `created_at`, `updated_at`) VALUES
            (1, 'https://www.youtube.com/embed/24O00Jz8R04', 'The iPhone Documentary - The Untold Story', NULL, NULL),
            (2, 'https://www.youtube.com/embed/h6fcK_fRYaI', 'The Egg', NULL, NULL),
            (3, 'https://www.youtube.com/embed/UjtOGPJ0URM', 'Finding alien life on a distant planet would be amazing news - or would it? If we are not the only intelligent life in the universe, this probably means our days are numbered and doom is certain.', NULL, NULL),
            (4, 'https://www.youtube.com/embed/jD0WQW_-O8k', 'How to start a business with no money: tips for entrepreneurs', NULL, NULL),
            (5, 'https://www.youtube.com/embed/SB16xgtFmco', NULL, NULL, NULL),
            (6, 'https://www.youtube.com/embed/4RAs9Y5wwDo', 'Raising money is hard. It\'s so hard most companies fail at it. \nIn this video, we\'ll look into traction requirements, pitch decks, alternative funding sources and on how to find investors. This is seed funding for entrepreneurs. \n\nI\'m the CEO of a company called Slidebean, and thousands of startups have used our platform to create their pitch decks. Their success is our success, and this is why we get involved with them and have learned a thing or to about what works, and what doesn\'t. \n\nI started my first company in 2011, and I failed at raising capital. I know the pain of shutting down a website you spent countless hours on, and having to email all your customers to say it\'s game over. \n\nThe problem with my first company is that we spent too much time trying to find investors, hence we failed to notice some of the fundamental flaws in our product. \n\nFor Slidebean, we raised a seed round of $800,000 which has allowed us to grow to a team of 25, increase our revenue to seven digits and become profitable in the process. And yeah, it was hard. \nI\'m telling you this because I want you to trust my advice. I tried and failed, and I can look back and see why I got a \'NO\' from most of the 142 investors I pitched. Yeah, 142 to raise $800,000. \n\nSo let\'s talk about traction, first. \n\nI have this problem with startup press (but we love YOU, @jordanrcrook). It gives new founders a false notion of how fundraising works. You read the story of Yo, an app that just sent notifications saying \'Yo\' and how they raised a $1,000,000 seed round, and you assume that\'s something anyone with a couple of lines of code can do. \n\nMost companies raise money AFTER getting traction. Very few companies raise money with just a prototype and no users, and certainly, NO company raises money without a fully formed founding team. \n\nThe most extreme case here is tech companies that are trying to raise money to hire a CTO. This makes no sense. Tech talent is expensive, and it\'s scarce, and the first proof that your company is worth something is that you managed to find a full stack developer that would turn down a job at Google to work on this idea. As a CEO, you need to be able to find and convince that guy, who joins your company for the stock and not for the salary; when he could be making $150,000/yr otherwise.\nThe reality of startup fundraising today, at least in Silicon Valley and New York, is that companies are pitching investors with traction, excellent traction. \n\nTraction usually comes in the form of revenue: tens of thousands of dollars per month, growing over +20% month-over-month. I\'m not making this up, check this article by VC Elizabeth Yin. Pure play, no-revenue traction counts only when you are dealing with millions of users and fantastic retention rates. \n\nSo how can you get to these numbers venture capitalists expect, if you don\'t have any money to start with? Yeah well, bootstrapping. \nWe bought our domain in 2013 and started working on our product, but it was only after 18 months that we managed to get any decent money to ramp up growth. It was $100,000 from the 500 Startups program, but we\'ll talk about accelerators in a minute. \n\nFrom May 2013 through October 2014 we bootstrapped. We did part-time consulting so we could pay our bills. We had a $1,000 salary each, and we shared an apartment. It was barely enough, but the backgrounds of the three founders made up for all the talent we needed: no need to hire anyone. Our company burn rate was probably $3,500 including our \'salaries\' and the services we needed. \n#seedfunding #startups #venturecapital', NULL, NULL),
            (7, 'https://www.youtube.com/embed/rTFqo81Ci_0', 'There\'s sexual reproduction, and there\'s asexual reproduction. Which one is more beneficial, and why?\nSexual reproduction has another benefit: It makes humans less prone to disease over time\n\"For decades, theories on the genetic advantage of sexual reproduction had been put forward, but none had ever been proven in humans, until now. Researchers have just shown how humanity\'s predispositions to disease gradually decrease the more we mix our genetic material together. This discovery was finally made possible by the availability in recent years of repositories of biological samples and genetic data from different populations around the globe.\"\n\"Making babies requires a male and a female, a sperm and an egg, right? Well, the wild world of animals is often more creative than the lot of us humans when it comes to making whoopee. In fact, some animals don\'t have sex at all, thank you very much.\"', NULL, NULL),
            (8, 'https://www.youtube.com/embed/JsUoG2DZ_S8', 'Most people view illegal drugs the same, but what\'s the difference between all of them? Is marijuana \"healthier\" than cocaine?\nCocaine users have impaired ability to predict loss\n\"Cocaine addicted individuals may continue their habit despite unfavorable consequences like imprisonment or loss of relationships because their brain circuits responsible for predicting emotional loss are impaired, according to a study conducted at the Icahn School of Medicine at Mount Sinai and published in The Journal of Neuroscience.\"', NULL, NULL),
            (9, 'https://www.youtube.com/embed/-zf7UxfL0zE', 'Have you ever wondered what a fly is doing when it lands on your food?\n“Answer this question while you are not eating: Which of the following would make you stop chowing down if you spied them while you were in a restaurant?”', NULL, NULL),
            (10, 'https://www.youtube.com/embed/nqOITqLfnkc', 'mmediately after you die, your body begins to decompose. Trace thought it would be interesting to take a look at everything that happens after your heart stops beating.\n“A study of seven terminally ill patients found identical surges in brain activity moments before death, providing what may be physiological evidence of ‘out of body’ experiences reported by people who survive near-death ordeals.”', NULL, NULL),
            (11, 'https://www.youtube.com/embed/jReX7qKU2yc', 'Consciousness: Crash Course Psychology', NULL, NULL),
            (12, 'https://www.youtube.com/embed/vo4pMVb0R6M', 'Intro to Psychology: Crash Course Psychology', NULL, NULL),
            (13, 'https://www.youtube.com/embed/7GGzc3x9WJU', 'Why Do We Dream?', NULL, NULL),
            (14, 'https://www.youtube.com/embed/s4XQo4txlk0', 'How Much Pain Can You Handle?', NULL, NULL),
            (15, 'https://www.youtube.com/embed/1a8pI65emDE', 'Which Came First - The Chicken or the Egg?', NULL, NULL),
            (16, 'https://www.youtube.com/embed/GU3JqoUDkjA', 'Is Masturbation Good For You?', NULL, NULL),
            (17, 'https://www.youtube.com/embed/SVQlcxiQlzI', 'How Much Sleep Do You Actually Need?', NULL, NULL),
            (18, 'https://www.youtube.com/embed/c9TXy_Ovweg', 'What if We ARE Alone in the Universe?', NULL, NULL),
            (19, 'https://www.youtube.com/embed/1L7EI0vKVuU', 'How An Igloo Keeps You Warm?', NULL, NULL),
            (20, 'https://www.youtube.com/embed/dbHj-Q1FTj8', 'Why Are We The Only Humans Left?', NULL, NULL);");

            DB::statement("INSERT INTO `sthub_posts` (`id`, `post_id`, `shared_by`, `classroom_id`, `batch_id`, `branch_id`, `course_id`, `institute_id`, `created_at`, `updated_at`) VALUES
            (1, 1, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 20:01:25', '2019-11-03 20:01:25'),
            (2, 2, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 20:25:21', '2019-11-03 20:25:21'),
            (3, 3, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 20:27:29', '2019-11-03 20:27:29'),
            (4, 4, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 20:41:22', '2019-11-03 20:41:22'),
            (5, 5, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 22:04:12', '2019-11-03 22:04:12'),
            (6, 6, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 22:16:29', '2019-11-03 22:16:29'),
            (7, 7, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 22:28:43', '2019-11-03 22:28:43'),
            (8, 8, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 22:36:08', '2019-11-03 22:36:08'),
            (9, 9, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 23:03:43', '2019-11-03 23:03:43'),
            (10, 10, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 23:06:17', '2019-11-03 23:06:17'),
            (11, 11, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 23:14:53', '2019-11-03 23:14:53'),
            (12, 12, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 23:16:05', '2019-11-03 23:16:05'),
            (13, 13, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 23:17:16', '2019-11-03 23:17:16'),
            (14, 14, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 23:21:00', '2019-11-03 23:21:00'),
            (15, 15, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 23:26:31', '2019-11-03 23:26:31'),
            (16, 16, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 23:33:58', '2019-11-03 23:33:58'),
            (17, 17, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 23:40:07', '2019-11-03 23:40:07'),
            (18, 18, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 23:43:41', '2019-11-03 23:43:41'),
            (19, 19, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 23:46:24', '2019-11-03 23:46:24'),
            (20, 20, 1,  NULL, NULL, NULL, NULL, 1, '2019-11-03 23:48:39', '2019-11-03 23:48:39');");


        DB::statement("INSERT INTO `subjects` (`id`, `Subject_name`, `subject_url`, `parent_subject_id`, `created_at`, `updated_at`) VALUES
        (42, 'Iphone', 'iphone', NULL, NULL, NULL),
        (43, 'Atheist', 'atheist', NULL, NULL, NULL),
        (44, 'Evolution', 'evolution', NULL, NULL, NULL),
        (45, 'Startup', 'startup', NULL, NULL, NULL),
        (47, 'Pitch Deck', 'pitch-deck', NULL, NULL, NULL),
        (46, 'Seed funding', 'seed-funding', NULL, NULL, NULL),
        (48, 'Sex', 'sex', NULL, NULL, NULL),
        (49, 'Weed', 'weed', NULL, NULL, NULL),
        (50, 'Disease', 'disease', NULL, NULL, NULL),
        (51, 'Human Body', 'human-body', NULL, NULL, NULL),
        (52, 'Consciousness', 'consciousness', NULL, NULL, NULL),
        (53, 'Psychology', 'psychology', NULL, NULL, NULL),
        (54, 'Human Brain', 'Human Brain', NULL, NULL, NULL),
        (56, 'Masturbation', 'Masturbation', NULL, NULL, NULL),
        (57, 'Sleep', 'sleep', NULL, NULL, NULL),
        (58, 'Universe', 'universe', NULL, NULL, NULL),
        (59, 'Igloo', 'igloo', NULL, NULL, NULL);
        ");

        factory(\App\Models\ExplorePagePost::class,3)->create(['page_section'=>'ExploreTopPost']);
        factory(\App\Models\ExplorePagePost::class,6)->create(['page_section'=>'HomePostContainer']);
        factory(\App\Models\ExplorePagePost::class,3)->create(['page_section'=>'ExploreSidebar']);
        factory(\App\Models\ExplorePagePost::class,3)->create(['page_section'=>'ExploreBottomPost']);

    }
}
