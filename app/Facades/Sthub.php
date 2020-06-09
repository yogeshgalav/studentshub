<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

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
    protected static function getFacadeAccessor()
    {
        return 'sthub';
    }
}
