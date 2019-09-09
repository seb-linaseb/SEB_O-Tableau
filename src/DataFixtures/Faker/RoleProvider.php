<?php

namespace App\DataFixtures\Faker;

use \Faker\Provider\Base as BaseProvider;


class RoleProvider extends BaseProvider{

        protected static $codes = [
        'ROLE_ADMIN',
        'ROLE_PROF',
        'ROLE_PARENT_ELU',
        'ROLE_PARENT'
    ];


       public static function roleCode(){
        return static::randomElement(static::$codes);
    }  
}