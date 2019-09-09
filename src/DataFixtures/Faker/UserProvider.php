<?php

namespace App\DataFixtures\Faker;

use \Faker\Provider\Base as BaseProvider;


class UserProvider extends BaseProvider{

        protected static $cities = [
        'Paris',
        'Nice',
        'Bordeaux',
        'Lille',
        'Rennes',
    ];


       public static function city(){
        return static::randomElement(static::$cities);
    }  
}