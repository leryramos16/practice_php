<?php 

class Security
{
    public static function generateToken($length = 32)
    {
        return bin2hex(random_bytes($length/2));
    }

    public static function hashToken($token)
    {
        return hash('sha256', $token);
    }

    public static function nowPlusMinutes($minutes)
    {
        return (new DateTime())->modify("+{$minutes} minutes")->format('Y-m-d H:i:s');
    }
}

