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
            2=>[
                'name'=>'Arts/Humanities',    
                'slug'=>'',    
                'jobs'=>[],    
                'exams'=>[],    
                'courses'=>[],
            ],   
            3=>[
                'name'=>'Business Management',    
                'slug'=>'management',    
                'jobs'=>[],    
                'exams'=>[],    
                'courses'=>[],
            ],   
            4=>[
                'name'=>'Commerce & Finance',    
                'slug'=>'finance',    
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
                'name'=>'Law',    
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
