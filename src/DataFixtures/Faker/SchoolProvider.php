<?php

namespace App\DataFixtures\Faker;

use \Faker\Provider\Base as BaseProvider;


class SchoolProvider extends BaseProvider{

        protected static $name = [
        'O\'Tableau',
    ];
        protected static $address = [
            'rue d\'Emery - 77184 EMERAINVILLE',    
    ];

        protected static $phone = [
            '01 23 45 67 89',      
    ];

        protected static $email = [
            'Otableau@gmail.com',      
    ];


       public static function schoolName(){
        return static::randomElement(static::$name);
    }

        public static function schoolAddress(){
            return static::randomElement(static::$address);
    }

        public static function schoolPhone(){
            return static::randomElement(static::$phone);
    }

        public static function schoolEmail(){
            return static::randomElement(static::$email);
    }

    
        
    

   
}