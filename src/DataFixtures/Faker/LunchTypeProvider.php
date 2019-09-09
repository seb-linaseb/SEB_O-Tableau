<?php

namespace App\DataFixtures\Faker;

use \Faker\Provider\Base as BaseProvider;


class LunchTypeProvider extends BaseProvider{

        protected static $codes = [
        'NC',
        'NORMAL',
        'SP',
        'PAI'
    ];


       public static function lunchCode(){
        return static::randomElement(static::$codes);
    }  
}