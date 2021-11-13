<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

/***
 * Class Sthub
 * @package App\Facades
 * @since 3.0.0
 */
class Sthub extends Facade
{
    /***
     * @return string
     * @since 3.0.0
     */
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

    public static function currentTab($tab){
        if(empty(request()->segment(1)) && $tab==='post'){
            return true;
        }
        if(false !== strpos(request()->segment(1), $tab)){
            return true;
        }

        return false;
    }

    public static function generateAlias($string)
    {
        if (!str_contains($string,' ')){
            return ucwords($string);
        }
        $newString = str_replace([' And ', ' In ', ' Of '], ' ', ucwords($string));
        $words = preg_split("/[\s,_-]+/", $newString);
        $acronym = "";

        foreach ($words as $w) {
            $acronym .= $w[0];
        }

        return $acronym;
    }

    public static function generateCallTrace()
    {
        $e = new \Exception();
        $trace = explode("\n", $e->getTraceAsString());
        $result = array();

        for ($i = 0; $i < 5; $i++) {
            $result[] = ($i + 1)  . ')' . substr($trace[$i], strpos($trace[$i], ' ')); // replace '#someNum' with '$i)', set the right ordering
        }

        return "\t" . implode("\n\t", $result);
    }

    public static function generatePassword()
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0,8);
    }
    public static function randomString()
    {
        return Str::random(20);
    }
    /**
 * Encode array from latin1 to utf8 recursively
 * @param $dat
 * @return array|string
 */
   public static function convert_from_latin1_to_utf8_recursively($dat)
   {
      if (is_string($dat)) {
         return utf8_encode($dat);
      } elseif (is_array($dat)) {
         $ret = [];
         foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);

         return $ret;
      } elseif (is_object($dat)) {
         foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

         return $dat;
      } else {
         return $dat;
      }
   }
}
