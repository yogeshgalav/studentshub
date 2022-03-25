<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function getCategory(){
        $path =  (dirname(__FILE__) .'/../../Services/simple_html_dom.php');
            require($path);
        for($i=1;$i<2;$i++){
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL, 'http://education-india.in/Education/Courses/?&Category_Id=FASH&PageNumber='.$i);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "__RequestVerificationToken=_IvTMY2Q5OoHWmjAToioXKcKojaWk0pQI-7VR8MEiUptO6n-gjr3ERyxP1FmNLfvg8B2-CFOylFZnzDh8D5yCFwpERnIkg3w2NpAUtAHrUs1&Discipline_ID=0&ProgramLevel_Id=0&Qualification_ID=0&CourseOfStudy_ID=0&InstituteType=All&Type=InstituteWise");
            curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
    
            $headers = array();
            $headers[] = 'Connection: keep-alive';
            $headers[] = 'Pragma: no-cache';
            $headers[] = 'Cache-Control: no-cache';
            $headers[] = 'Sec-Ch-Ua: \"Google Chrome 80\"';
            $headers[] = 'Dnt: 1';
            $headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36';
            $headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
            $headers[] = 'Accept: /';
            $headers[] = 'Sec-Fetch-Dest: empty';
            $headers[] = 'X-Requested-With: XMLHttpRequest';
            $headers[] = 'Origin: http://education-india.in';
            $headers[] = 'Sec-Fetch-Site: same-origin';
            $headers[] = 'Sec-Fetch-Mode: cors';
            $headers[] = 'Referer: http://education-india.in/Education/Courses/';
            $headers[] = 'Accept-Language: en-US,en;q=0.9,hi;q=0.8,te;q=0.7';
            $headers[] = 'Cookie: __RequestVerificationToken=nRkXMDor5vExtHvPbgzrwXz1Ty_aTGmwFbD4g467mbJaMwOc7TrcLd-UiKgMEF28z9CQGcodmJx-JNQce3KsyerblBThNb2hVwWF9WUo2sk1; ARRAffinity=82ae625e523a0a5d8e6a49690460dbb4b4e839206cf7afe7183e6ef2687bcea8; _gcl_au=1.1.1967393802.1585816508; _ga=GA1.3.223059005.1585816509; _gid=GA1.3.1499003994.1585816509; ASP.NET_SessionId=kaflrrtpsbvrvzucsjuz1ycl';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
            $html = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            $trs = str_get_html($html)->find('table.index tr');
            for($j=0;$j<20;$j++){
                $tr=$trs[$j];
                $course=$tr->find('td',1);
                $duration=$tr->find('td',2);
                $eligibility=$tr->find('td',3);
                if($course==null){
                    continue;
                }
                $new_course=new \App\Models\Course;
                $new_course->course_name=trim($course->plaintext);
                $new_course->duration=$duration ? trim($duration->plaintext) : null;
                $new_course->eligibility=$eligibility ? trim($eligibility->plaintext) : null;
                $new_course->category_id=12;
                $new_course->country_id='IN';
                $new_course->save();
            }
        }    
        
        }
}
