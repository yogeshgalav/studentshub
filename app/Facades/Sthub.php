<?php

namespace App\Facades;

class Sthub
{
        public static function ucWordSome($string)
        {
            $str = strtolower($string);
            $str_arr = preg_split('/\s+/', $str);
            $result_arr = [];
            $exclude = 'a,an,the,for,and,nor,but,or,yet,so,such,as,at,around,by,after,along,for,from,of,on,in,to,with,without';
            $excluded = explode(",", $exclude);
            foreach ($str_arr as $word) {
                $result_arr[] = !in_array($word,$excluded) ? ucfirst($word) : $word;
            }
            return implode(' ', $result_arr);
        } 

        public static function generateAlias($string){
            if (!str_contains($string,' ')){
                return strtoupper(substr($string,0,3));
            }
            $string = str_replace([' And ', ' In ', ' Of '], ' ', ucwords($string));
            $words = preg_split("/[\s,_-]+/", $string);

            $acronym = "";
            foreach ($words as $w) {
                $acronym .= strtoupper(mb_substr($w, 0, 1));
            }
            return $acronym;
        }
}