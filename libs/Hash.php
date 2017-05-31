<?php

/**
 * Author: ahmed-dinar
 * Date: 5/31/17
 */
class Hash {

    //HASHING password with salt
    public static function make($string, $salt = ''){
        return hash('sha256', $string . $salt);
    }

    //make some encrypted salt
    public static function salt($lenth){
        return mcrypt_create_iv($lenth);
    }

    //making unique hash to avoid conflict
    public static function unique(){
        return self::make(uniqid());
    }
}