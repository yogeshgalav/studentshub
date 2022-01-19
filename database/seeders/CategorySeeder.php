<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $categories =[
            1=>[
                'quality_check'=>'
                • Academic Orientation
                • Good with Mathematics and Sciences with affinity
                towards Technology
                • Interest in latest Machines, Gadgets and repairing
                things Etc.
                • Ability to spend long hours with books and/or
                computers during study and in the field during
                Practical application
                ',
                'exams'=>'
                JEE-MAIN / ADVANCED
                BITSAT (Birla)
                VITEEE (Vellore)
                SITEEE (Symbiosis)
                SRMJEE
                NPAT (Narsee Monjee)
                MET (Manipal)
                KIIT-EE (Kalinga)
                UPES-EAT
                GAT (Gitam)
                GUJ-CET
                MHT-CET
                KEA-CET
                TS-EAMCET
                AP-EAMCET
                WB-JEE
                '
            ],
            3=>[
                'quality_check'=>'
                • Academic and Practical Orientation
                • Good with Mathematics and Sciences with
                affinity towards Botany
                • Interest in Plants and life Sciences.
                • Academic and People Orientation
                • Good with Basic Sciences with strong affinity towards
                Plants, Animals and life Sciences.
                • Excellent Memorization power
                • Ability to spend long hours with books and/or
                computers during study and in the field during
                Practical application
                • Academic and People Orientation
                • Good with Basic Sciences with affinity towards
                Practical Application
                • Interest in Life and Life Sciences.
                • Ability to spend long hours with books and/or
                computers during study and in the field during
                Practical application
                • Academic and People Orientation
                • Good with Basic Sciences with affinity towards
                Zoology
                • Interest in Animals and Life Sciences.
'
            ],
            7=>[
                'quality_check'=>'
                • Mixture of Academic, People and Creative
                Orientation
                • Good with Languages and Social Sciences with
                affinity towards Theory Reading.
                • Good with Observation and Analyzing Power.
                • Comfortable with Versatile Reading and Writing.
                ',
                'exams'=>'
                HSEE
                TISS-BAT
                DUET
                CUET
                BA-CET
                AMU-ET
                JMI-ET
                ',
                'jobs'=>[
                    '• Teacher
                    • Writer
                    • Philosopher
                    • Political Scientist
                    • Psychologist
                    • Public Administrator
                    • Restorer
                    • Sociologist
                    • Social Worker
                    • Translator
                    • International Business
                    • Journalist
                    • NGO Manager
                    • Political Analyst
                    • Publisher
                    • Sports Psychologist
                    • Advertising Manager
                    • Public Relations Manager
                    • Business Analyst
                    • Business Consultant
                    • Economic Analyst
                    • Environmental Affairs
                    • Human Resource
                    Manager'
                ]
            ],
            0=>[
                'name'=>'Agricultural Science',    
                'slug'=>'agriculture',    
                'quality_check'=>'
                • Academic and Practical Orientation
                • Good with Mathematics and Sciences with
                affinity towards Botany
                • Interest in Plants and life Sciences.
                • Ability to spend long hours with books and/or
                computers during study and in the field during
                ',
                'jobs'=>[
                    'Agriculturist',
                    'Agricultural Economist',
                    'Agronomist',
                    'Agricultural Biotechnologist',
                    'Agricultural Biochemist',
                    'Floriculturist',
                    'Food Technologist',
                    'Fruit Scientist',
                    'Horticulturist',
                    'Nutritionist',
                    'Plant Pathologist',
                    'Seri culturist',
                    'Soil Scientist',
                    'Vegetable Scientist',
                ],    
                'exams'=>[],    
                'courses'=>[
                    'B.Sc. (Agriculture)',
                    'B.Sc. (Sericulture)',
                    'B.Sc. (Horticulture)',
                    'B.Sc. (Forestry)',
                    'B.Sc. (Community/Home Science)',
                    'B.Sc. (Food Nutrition & Dietetics)',
                    'B.Tech. (Agriculture)',
                    'B.Tech. (Food Technology)',
                    'B.Tech. (Dairy Technology)',
                    'B.Tech. (Biotechnology)',
                ],
            ],   
            1=>[
                'name'=>'Architecture',    
                'slug'=>'architecture',
                'quality_check'=>'
                • Academic and Creative Orientation
                • Good with Mathematics and Sciences with very
                strong Visualization and Observation.
                • Interest in Building Structures, Engineering Drawing
                and Sketching.
                • Ability to spend long hours with books and/or
                computers during study and in the field during
                Practical application
                ',
                'jobs'=>[
                'Archeologist',
                'Architect',
                'Architectural Engineer',
                'Surveyor',
                'Building Inspector',
                'Conservation Officer',
                'Interior Designer',
                'Landscape Architect',
                'Restoration Architect',
                'Spatial Designer',
                'Town Planner',
                'Urban Planner',
                ],    
                'exams'=>'
                Eligibility Criteria: 10+2 with PCM/PCB
                National Level Exams
                • NEET (National Eligibility cum Entrance Test)
                • ICAR-AIEEA ( Indian Council of Agricultural
                Research-All India Entrance Examination for
                Admission)
                • JEE-MAIN (Joint Entrance exam)

                State Level Exams
                • GUJCET (Gujarat)
                • MP-PAT (Madhya)
                • PAU-CET (Punjab)
                • UP-CATET (Uttar)
                • MHT-CET (Maharashtra)
                • AP-EAMCET (Andhra)
                • BCECE (Bihar)
                • HAU-PAT (Haryana)
                • CH-PAT (Chattisgarh)
                • HPAU-ET (Himachal)
                • JCECE (Jharkhand)
                • SKUAST (J & K)
                • KEA-CET (Kerala)
                • OUAT (Orissa)
                • RJET (Rajasthan)
                ',    
                'courses'=>[
                    'B.Arch',
                    'B.I.D.',
                    'B.Plan',
                    'B.Tech. (Planning)',
                ],
            ],
            3=>[
                'name'=>'Business Management',    
                'slug'=>'management',  
                'quality_check'=>'
                • People and Practical Orientation
                • Good with Numerics and Economics
                • Interest in field of Business Transactions,
                Management and Administration
                • Street smart personality with ability to work with a
                group of people as a team.
                ',  
                'jobs'=>[
                   ' • Brand
                    • Entrepreneur
                    • Event
                    • Financial Investment
                    • Human Resource
                    • Information Technology
                    • Marketing
                    • Market Research
                    • Public Relations
                    • Project
                    • Risk
                    • Sales
                    • Social Media
                    • Supply Chain'
                ],    
                'exams'=>'
                IPM-AT (IIM Indore/Rohtak)
                NPAT (Narsee Monjee)
                SET (Symbiosis)
                DUET (Delhi Univ.)
                MET (Manipal Univ.)
                B-UMAT (BVP)
                JMI-ET (Jamia)
                BBA-CET (IPU)
                CUET (Christ)
                St. Xavier’s-OT
                KIIT-EE (Kalinga)
                MSU-ET
                KUAT (Karnavati)
                JET (Jain Univ.)
                AU-MAT (Alliance)
                SNUSAT + APT (Shiv)
                ',    
                'courses'=>[
                    'B.B.A. (Business Administration)
                    B.B.A. (Hons.)
                    B.M.S. (Management Studies)
                    B.B.S. (Business Studies)
                    BBA+MBA (Integrated)
                    '
                ],
            ],   
            4=>[
                'name'=>'Commerce & Finance',    
                'slug'=>'finance',
                'quality_check'=>'
                Quality Check for Commerce & Finance
                • Academic Orientation
                • Good with Mathematics and Economics with affinity
                towards Accounts and Statistics
                • Interest in Financial Management and Data Analysis.
                • Ability to spend long hours working with Data and
                Numbers on paper and/or on computers.
                '    
                'jobs'=>[],    
                'exams'=>[],    
                'courses'=>[],
            ],   
            5=>[
                'name'=>'Computer Applications',    
                'slug'=>'computer',    
                'jobs'=>[],    
                'exams'=>[],    
                'courses'=>[],
            ],   
            6=>[
                'name'=>'Design & Fine Arts',    
                'slug'=>'design',    
                'jobs'=>[],    
                'exams'=>[],    
                'courses'=>[],
            ],   
            7=>[
                'name'=>'Economics',    
                'slug'=>'economics',    
                'jobs'=>[],    
                'exams'=>[],    
                'courses'=>[],
            ],   
            8=>[
                'name'=>'Engineering & Technology',    
                'slug'=>'technology',    
                'jobs'=>[],    
                'exams'=>[],    
                'courses'=>[],
            ],   
            9=>[
                'name'=>'Hotel Management',    
                'slug'=>'hospitality',    
                'jobs'=>[],    
                'exams'=>[],    
                'courses'=>[],
            ],   
            10=>[
                'name'=>'Law and Humanity',    
                'slug'=>'law',    
                'jobs'=>[],    
                'exams'=>[],    
                'courses'=>[],
            ],   
            11=>[
                'name'=>'Liberal Studies',    
                'slug'=>'liberal',    
                'jobs'=>[],    
                'exams'=>[],    
                'courses'=>[],
            ],   
            12=>[
                'name'=>'Mass Communication',    
                'slug'=>'journalism',    
                'jobs'=>[],    
                'exams'=>[],    
                'courses'=>[],
            ],   
            13=>[
                'name'=>'Medicine & Surgery',    
                'slug'=>'',    
                'jobs'=>[],    
                'exams'=>[],    
                'courses'=>[],
            ],   
            14=>[
                'name'=>'Paramedical Science',    
                'slug'=>'paramadical',    
                'jobs'=>[],    
                'exams'=>[],    
                'courses'=>[],
            ],   
            15=>[
                'name'=>'Performing Arts',    
                'slug'=>'performing-arts',    
                'jobs'=>[],    
                'exams'=>[],    
                'courses'=>[],
            ],   
            16=>[
                'name'=>'Pure Science',    
                'slug'=>'science',    
                'jobs'=>[],    
                'exams'=>[],    
                'courses'=>[],
            ],   
            17=>[
                'name'=>'Rehabilitation Science',    
                'slug'=>'rehabilitation',    
                'jobs'=>[],    
                'exams'=>[],    
                'courses'=>[],
            ],   
            18=>[
                'name'=>'Sports & PE',    
                'slug'=>'sports',    
                'jobs'=>[],    
                'exams'=>[],    
                'courses'=>[],
            ],   
            19=>[
                'name'=>'Veterinary Science',    
                'slug'=>'Veterinary',    
                'jobs'=>[],    
                'exams'=>[],    
                'courses'=>[],
            ],   
            20=>[
                'name'=>'General Knowledge',    
                'slug'=>'general',    
                'jobs'=>[],    
                'exams'=>[],    
                'courses'=>[],
            ],   
        ];
    }
}
