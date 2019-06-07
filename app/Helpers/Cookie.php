<?php

namespace App\Helpers;

class Cookie 
{
    public static function has($name) 
    {
        return (isset($_COOKIE[$name])) ? true : false;
    }

    public static function get($name) 
    {
        return $_COOKIE[$name];
    }

    public static function put($name, $value, $expiry) 
    {
        if(setcookie($name, $value, time() + $expiry, Config::get('cookie/path'))) 
        {
            return true;
        }
        return false;
    }

    public static function delete($name) {
        self::put($name, '', time() -1);
    }
}
