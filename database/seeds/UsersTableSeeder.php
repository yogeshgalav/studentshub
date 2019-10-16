<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = "INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES    
(1, 'Yogesh  Galav',  'yogesh@gmail.com', '$2y$10\$xZQrSvgNjXC23GpIU5WD.e2ZlMhTGn4JbpL6N6xXcZ9XW3sI9mKPO', 'AlIXWxYOU5t7k50MAbYQO1sHDuUZVeEgAIHz3xddL7FkRVrB2KNO0Vmw02tK', '2018-03-26 21:45:18', '2018-03-26 21:45:18'),
(2, 'Prateek Sharma',  '2014pcemeprateek@poornima.org', '$2y$10\$bU6Zjs5uIOAKhRQ3nn5CTOxOJQOVOCEm./MAiJeS6DrGwtIrGgqgS', NULL, '2018-03-26 21:45:18', '2018-03-26 21:45:18'),
(3, 'pushkar jat',  '2017pgicspushkar034@poornima.org', '$2y$10\$UvMYRpbrrM6RqtUFPZOP8elB0JS/z4TCiR9PSlx6tCUOyx8MtLixS', NULL, '2018-03-28 10:41:30', '2018-03-28 10:41:30'),
(4, 'VIKAS SHARMA',  '2017pgimevikas036@poornima.org', '$2y$10\$wE/hFyBCM7WULEro7.3aheVaWt1LdaJ684VNnZ2w1MwQE33N6ZEmq', NULL, '2018-03-28 10:41:32', '2018-03-28 10:41:32'),
(5, 'Sunil godara',  'sunilgodaranathwana@gmail.com', '$2y$10\$jWDsR/AytDfvvKkbuj989eZI9CUBUls7Rod88qCIST7zcduPC52Iy', NULL, '2018-03-28 10:42:06', '2018-03-28 10:42:06'),
(6, 'Mayank Bagaria',  '2017pgicsmayank022@poornima.org', '$2y$10\$paUEn1PQ6/M23Wr.x5iVreWZ7/Z1g1bP06ddcduGneFT0LwoQTFei', NULL, '2018-03-28 10:43:35', '2018-03-28 10:43:35'),
(7, 'Naveen kumar',  '2017pgimenaveen025@poornima.org', '$2y$10\$vlkNVhT6p4W/yyrajFRT0.U.HL.hTFpdFpqfr9W9wTnlVOqjbNc5S', NULL, '2018-03-28 10:44:33', '2018-03-28 10:44:33'),
(8, 'Dhaval Rajora ',  '2017pgicsdhaval013@poornima.org', '$2y$10\$6JtcfPgLEeeeBsNc/2ki1u5STAAxgC5za2bsRcO9679nWzkaQw9YO', NULL, '2018-03-28 10:44:40', '2018-03-28 10:44:40'),
(9, 'Abhishek gurjar',  '2017pgimeabhishek001@poornima.org', '$2y$10\$s5MlmuCtBX2XBDotWX1xoOwE6ZNfI/YE/8Do7RYWe.ELLy00q30PK', NULL, '2018-03-28 10:44:53', '2018-03-28 10:44:53'),
(10, 'Yash sharma',  '2017pgicsyash049@poornima.org', '$2y$10\$YnOOiNbCyM52qrDr6e24he4fbTHhQwjh/GqlfYVkRmCZ9kRZBNDCu', NULL, '2018-03-28 10:45:02', '2018-03-28 10:45:02'),
(11, 'ranjit singh rathore',  '2017pgics053@poornima.org', '$2y$10\$Wg3jlXiKVWlPZ8bEjwQz8u6JxXQl/J2eaO/SnwHPyOgJcB9ztAFFS', NULL, '2018-03-28 10:45:16', '2018-03-28 10:45:16'),
(12, 'Sandeep ',  '2017pgimesandeep030@poornima.org', '$2y$10\$yf2m9Vv5.QUHhxjFJy2MjuNtMZgjpiD.dAm54EcHhkOqYXQNy4aAy', NULL, '2018-03-28 10:45:18', '2018-03-28 10:45:18'),
(13, 'Sunil godara',  '2017pgecesunil023@poornima.org', '$2y$10\$Fy4Vz9JV6GI4DNB9mV14N.3SOT.ZwfLAl5ScM.TwiGInH8kl4OpkW', NULL, '2018-03-28 10:45:33', '2018-03-28 10:45:33'),
(14, 'Dushyant saini ',  '2017pcemedushyant030@poornima.org', '$2y$10\$00mg4yAJFTBXDfuDbiIneebz4cnRSxNwLyvTXKdjqctZiq81Iw.Ae', NULL, '2018-03-28 10:47:04', '2018-03-28 10:47:04'),
(15, 'Himmat Singh Rao',  '2017pgimehimmat017@poornima.org', '$2y$10\$7jhzBvXCmOBfzJANS7kBeubrxQXOKpUhgeuO5sYuhU/uOHmuTUY.i', NULL, '2018-03-28 10:47:13', '2018-03-28 10:47:13'),
(16, 'Saurabh Kumar Singh',  '2017pgicesaurabh022@poornima.org', '$2y$10\$qtW74RMySu.lvvtefONBsufiAKxdI.y4Z9JZOL2WANge/FYUORnay', NULL, '2018-03-28 10:47:18', '2018-03-28 10:47:18'),
(17, 'Govind Singh tomar ',  '2017pgimegovind015@poornima.org', '$2y$10\$69pUtkVRBiZQgLS2B5OBSedE/E70Eok2CH8H6bwEpzhl4wWXRmdEy', NULL, '2018-03-28 10:50:08', '2018-03-28 10:51:26'),
(18, 'Rishabh Dadhich',  '2017pgimerishabh029@poornima.org', '$2y$10\$zqSxgcmc5NBjY3FYHnKiLebj9xOEheNYGCG/49Wr6TDoZ4t2zrGvC', NULL, '2018-03-28 10:51:07', '2018-03-28 10:51:07'),
(19, 'ankit kumar sisodiya',  '2017pgimeankit037@poornima.org', '$2y$10\$16uGBdBWI8Ijhk1KiZ.yz.a0LoFLLbLE9W9SvrF8VUjLG/z8Oy1x2', NULL, '2018-03-28 10:54:17', '2018-03-28 10:54:17'),
(20, 'Anand Purushottam',  'purushottamanand857@gmail.com', '$2y$10\$JTOTbkqleC42IKvv7VtRsu7M7g1YfuyM/S81yz8XDR/vEIIkk3jZO', NULL, '2018-03-28 10:54:44', '2018-03-28 10:54:44'),
(21, 'Mohammad sadiq ',  '2017pgicsmohammad052@gamil.com', '$2y$10\$f9vqZsNpJhT26PJPnK5VL.t9fQWUu8QX1MFdTP38U/lcsre8LZqoO', NULL, '2018-03-28 11:00:30', '2018-03-28 11:00:30'),
(22, 'DIVYA MAHALA',  '2017pgimedivya014@poornima.org', '$2y$10\$e1lxwxAAeg0WIRM0Gj3BNuRkYn1sgjb9SFXROp.lN3Xs3j2NOKWB.', NULL, '2018-03-28 11:01:13', '2018-03-28 11:01:13'),
(23, 'Ishan Sen',  '2017pcemeishan046@poornima.org', '$2y$10\$.aaFfIsJnMcG0bE3FUwcruNniezaWJ.uRwkGQn5xRhFj81T2Y82fe', NULL, '2018-03-28 11:01:38', '2018-03-28 11:01:38'),
(24, 'Nikhil Sen',  '2017pgicsnikhil025@poornima.org', '$2y$10\$x9rzze9cnPnV760OvoXKvu0s.Uu4IjuBZqWtOrcpmWblM5TwBUCqu', NULL, '2018-03-28 11:01:44', '2018-03-28 11:01:44'),
(25, 'Siddhant Jain',  '2017pgicssiddhant044@poornima.org', '$2y$10\$SqPDLjlT47JcxsQI0wjMwOH5bweBTHhsq76wSNjeh8PCeMKiNBLzG', NULL, '2018-03-28 11:01:52', '2018-03-28 11:01:52'),
(26, 'Manav Banerjee',  'manavbanerjee007@gmail.com', '$2y$10\$zvj5buOTqOkXgtnjhstqC.uZUELR6/N/I/SBjbb0CNE43CzfgTTXa', NULL, '2018-03-28 11:02:27', '2018-03-28 11:02:27'),
(27, 'Aditya gupta',  '2017pgimeaditya003@poornima.org', '$2y$10\$Qiq47RsUDCSJsFmzG4YxYewAXkStOiiJvGEwvmWgnv6r0v3K9hUs.', NULL, '2018-03-28 11:02:51', '2018-03-28 11:02:51'),
(28, 'Mragank mishra',  '2017pgicemragank013@poornima.org', '$2y$10\$hBOgNQj653NLQyBsz9tIIO68rFmfLOIs/VHZBuy1L7J3TEA.8KxQG', NULL, '2018-03-28 11:02:55', '2018-03-28 11:02:55'),
(29, 'Manish barman',  '2017pgimemanish@poornima.org', '$2y$10\$7QrSobjjr7c86Qjfy28P/OOSDlQKOwyujvIadQBGbkIgTienDdFNq', NULL, '2018-03-28 11:02:59', '2018-03-28 11:02:59'),
(30, 'Rahul Kumar Alria',  '2017pgimerahul028@poornima.org', '$2y$10\$WsTY2G4F7DxIus8Q2mXKwuJaa0hjTWyGANII7f8nNk4CwPr.kdjAS', NULL, '2018-03-28 11:04:03', '2018-03-28 11:04:03'),
(31, 'piyush gupta',  '2017pgicspiyush028@poornima.org', '$2y$10\$tkxl4YkUu9S2y4dJNGCN4ONl78AIHR6Ay5bqRzG4zFQ6MwpJ5Pq9.', NULL, '2018-03-28 11:05:18', '2018-03-28 11:05:18'),
(32, 'Dheeru Chahal',  '2017pgicsdheeru014@poornima.org', '$2y$10\$LEXHGPdZPmHoNn7BlIBRR.hmQjK3fiGPOEmwLzEcQwteqahpEGUA2', NULL, '2018-03-28 11:05:30', '2018-03-28 11:05:30'),
(33, 'Rahul sharma',  '2017pgicsrahul035@poornima.org', '$2y$10\$X8IDVgrUYhoQ.gXuEVWLaOKtw2dOvnkiyGoJXJrDijjyoKu/SYKXO', NULL, '2018-03-28 11:06:50', '2018-03-28 11:06:50'),
(34, 'Sanjay singh',  'sanjaysingh15397@gmail.com', '$2y$10\$y/lsvh1BjGc8EZoX1Mpx6.lkQQ4fQR6bMpObt.mF3VfyO/IN5.PYi', NULL, '2018-03-28 11:25:52', '2018-03-28 11:25:52'),
(35, 'Prashant Godara',  '2015pgicivprashant082@poornima.org', '$2y$10\$xl0QW9wasmbAitsA0q8DmeucSttbGGb1nKqFoiT8dlVTHb/9L1lWu', NULL, '2018-03-28 11:26:46', '2018-03-28 11:26:46'),
(36, 'Yashwant Kumar Choudhary',  'ykd07081@gmail.com', '$2y$10\$I.25TL8sfbmnSIeJU130ze5KbWPcQXL3FMjQH/aExNh9FeC3svAHe', NULL, '2018-03-28 11:27:53', '2018-03-28 11:27:53'),
(37, 'Rahul Bhagat',  'rbhagat062@gmail.com', '$2y$10\$3fhm/0ayZqm8Hd3f0QO/neqpharrfb1Zp/cUJeqrWHjVfUSvey.8G', NULL, '2018-03-28 11:31:09', '2018-03-28 11:31:09'),
(38, 'Shivam Sharma',  'sshivdutt63@gmail.com', '$2y$10\$rx80lL4SexgUhY9qkCVLkuqgn8ra2TCoRlOfB.sGwXABW4rqqqO.e', NULL, '2018-03-28 11:39:53', '2018-03-28 11:39:53'),
(39, 'Divyansh sharma',  '2016pgicedivyansh014@poornima.org', '$2y$10\$A/iyfR9u9sUe6JclTY.beOaN9Im9Wz0AJM7ms3xgkHm5IBF.jtT6O', NULL, '2018-03-28 11:41:33', '2018-03-28 11:41:33'),
(40, 'Ikraj khan ',  '2016pgi16cvikraj019@poornima.org', '$2y$10\$20NU5pmdHVzbm0MHhlcwfOFDSYOaTpb1oW6qvqDlM860PUQP1LUOi', NULL, '2018-03-28 12:08:31', '2018-03-28 12:08:31'),
(41, 'Himmat Sangwa',  'himmatsangwa1212@gmail.com', '$2y$10\$nzwHQgVwINHzt5kHmzJy3OriboRk9.1vUr389xCUVppVU0Zi02tpy', NULL, '2018-03-28 12:10:57', '2018-03-28 12:10:57'),
(42, 'Hemant Khandelwal',  '2016pgimehemant@Poornima.org', '$2y$10\$.gAKlTzi8hKUS5rYnTk03eVuoyRTbBATQfs9/SLYL9xHx6onqaQS2', NULL, '2018-03-28 12:11:50', '2018-03-28 12:11:50'),
(43, 'ShyamSinghRajpurohit',  '2017pgimeshyam033@poornima.org', '$2y$10\$Sy/upIkd02I6X9d7mdpkjeRzoHKk9C/yMITfsUbtePjFzrKiwsW6.', NULL, '2018-03-28 15:32:44', '2018-03-28 15:32:44'),
(44, 'HarshGarg',  '2016pgicv016harsh@poornima.com', '$2y$10\$/VkAlU.c4EocieEgLeCTleq1oQhhOjMT38hr/51YANxeUQS6wFs2O', NULL, '2018-03-30 11:11:51', '2018-03-30 11:11:51'),
(45, 'HarshGarg',  '2016pgicvharsh016@poornima.com', '$2y$10\$eDk8ecpXlbSQMwbbp4XFZ.ne1VoIdRqs/siicVV7e1ioPXY9onSgC', NULL, '2018-03-30 11:13:21', '2018-03-30 11:13:21'),
(46, 'AdityaSingh',  '2016pgicvaditya063@poornima.org', '$2y$10\$eaPyHnmV90UoZs8y/9qkQ.0XfzTnHA5/Y5OfU8PA358gVMMm.CSHq', NULL, '2018-03-30 11:13:33', '2018-03-30 11:13:33'),
(47, 'BhagwanSingh',  '2016pgimebhagwan018@poornima.org', '$2y$10\$I3zmdaPFuykY8XMovASBde498hdSvkqvK36NbzTwt3v1zRJm7ozYC', NULL, '2018-03-30 11:14:11', '2018-03-30 11:14:11'),
(48, 'Dhruvansh',  'dhruvanshrotwar@gmail.com', '$2y$10\$4k9sEaKtYn4V8phkMK0l1.oXmScXdb3kiWQ.d4FI5VZTUuPNpI.vm', NULL, '2018-03-30 11:14:29', '2018-03-30 11:14:29'),
(49, 'Mohnish',  'mohnish.kr183@gmail.com', '$2y$10\$7uMDNi/gAhjpxtbU93H4zOFd.HYsogQohYAojwQKQs4NGtMrPrk1O', NULL, '2018-03-30 11:16:33', '2018-03-30 11:16:33'),
(50, 'SudhirKumar',  'sudhirkumar199888@gmail.com', '$2y$10\$nrmq7Cf6mOOISh2r.4CwteokPKIodBuD0vbF49F53MnNOCwMOYI7m', NULL, '2018-03-30 11:17:15', '2018-03-30 11:17:15'),
(51, 'YogeshGalav',  '2014pcecsyogesh@poornima.org', '$2y$10\$0Wnnn13E95fxUYtAzygVF.bVq26IUFZw7w4WtuyqYRA11B4FMEji2', 'eTmQ8dh6jU5Tw7B3yMFM1aiQxaBdiag1D9SugkFpKUtFHeQ8JmJr61JU4oXG', '2018-03-31 11:51:27', '2018-04-05 01:58:51'),
(52, 'SourabhPrajapati',  'sourabhprajapati306@gmail.com', '$2y$10\$jRRQuB0KRvzgUqSb0hoFR.2/dXFOyHpdWm5qwY17/.XyMPW0CYHBq', NULL, '2018-04-03 11:27:19', '2018-04-03 11:27:19'),
(53, 'SiddhantSanadhaya',  'sid.sanadhaya@gmail.com', '$2y$10\$27Z8Xbu48dmejZX8dBaV9.GY6OZSYLYDo./4uruLPELzW1N5CsK7.', NULL, '2018-04-03 12:57:44', '2018-04-03 12:57:44'),
(54, 'VijayKumarSharma',  '2014pcecsvijay121@poornima.org', '$2y$10\$fycTslQawUwG1m1ta1ATN.5/hQ9uW2QNQ1taAXb8q7B/TlWzYzn8i', 'hohMEUmzkAOBeBl3WJEzMb6jenDUoyakUhP10Dxd80ciOzAT0NPTrnnkXD7I', '2018-04-23 01:41:28', '2018-04-23 01:53:07'),
(55, 'YogeshGalav',  'mr.yogesh.galav@gmail.com', '$2y$10\$LOCIEFW7eCsjkPGxTlbgdO7xek.Pfu5crIyAugAklHmFxI8HspQam', '4Zi1FVuaryTGSOglos4Sn2EIIMt55869r09g4ftnFtkOvi8epmiE17iYE8br', '2018-05-05 14:03:51', '2018-07-09 23:30:25'),
(56, 'Shubham',  'shubham.soni@endivesoftware.in', '$2y$10\$54tKYoj/9lpFnHKljutLre5zXmOfb.ua1Bj/.WgGk4B6LwGFmmYHy', NULL, '2018-05-22 06:45:16', '2018-05-22 06:45:16'),
(57, 'MohitKumar',  'mohit.mupparaju@gmail.com', '$2y$10\$CQYhUb8YFjP4bsPwcCs2Kuy0wG33vCak3zHUZu3SlT8N47qVeW2Ru', NULL, '2018-06-08 23:01:45', '2018-06-08 23:01:45'),
(58, 'Shawn',  'shawnmahi@gmail.com', '$2y$10\$wMB7i901dgoObr179OtkSudATwLPq/L41WejW9pi2mD0IF9HsFFeK', NULL, '2018-06-11 22:23:25', '2018-06-11 22:23:25'),
(59, 'AgniPrashun',  'agniprashun@icloud.com', '$2y$10\$O92TvzjASYc/ZuBkw88w3emyStARclW6oe5HXF6YWH.iVwtGNtSk.', 'QRroHDS6ZgJHuVbXaDAOC2N49XN9YKC9XhVEiWtF9csuQ8DDsXBFi0b4O1Zr', '2018-06-17 13:36:16', '2018-06-17 14:56:52');
;";
        DB::unprepared($sql);
    }

    
}
