<?php

namespace App\Facades;

use Illuminate\Support\Facades\Auth as AuthUser;

class Auth extends AuthUser
{
    public static function student(){
        return self::user()->student()->first();
    }
}
