<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Str;

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
        $str = ucwords($string);
        $exclude = 'a,an,the,for,and,nor,but,or,yet,so,such,as,at,around,by,after,along,for,from,of,on,in,to,with,without';
        $excluded = explode(",", $exclude);
        foreach ($excluded as $noCap) {
            $str = str_replace(ucwords($noCap), strtolower($noCap), $str);
        }
        return ucfirst($str);
    }

    public static function generateAlias($string)
    {
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
}
