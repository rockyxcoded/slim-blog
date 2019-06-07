<?php

namespace App\Helpers;

class Hash
{
    public static function make($string)
    {
        return password_hash($string, PASSWORD_BCRYPT);
    }

    public static function verify(string $password, string $hashed_password)
    {
    	return password_verify($password, $hashed_password);
    }
    
    public static function unique()
    {
        return self::make(uniqid());
    }
}
