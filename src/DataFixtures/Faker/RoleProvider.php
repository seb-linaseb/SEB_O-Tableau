<?php

namespace App\DataFixtures\Faker;

use \Faker\Provider\Base as BaseProvider;


class RoleProvider extends BaseProvider{

        protected static $codes = [
        'ROLE_ADMIN',
        'ROLE_PROF',
        'ROLE_ELU',
        'ROLE_PARENT'
    ];


       public static function name(){
        return static::randomElement(static::$codes);
    }

    
        
    

   
}