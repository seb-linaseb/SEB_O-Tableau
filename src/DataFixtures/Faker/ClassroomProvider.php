<?php

namespace App\DataFixtures\Faker;

use \Faker\Provider\Base as BaseProvider;


class ClassroomProvider extends BaseProvider{

        protected static $names = [
        'Petite Section',
        'Moyenne Section',
        'Grande Section',
        'CP',
        'CE1',
        'CE2',
        'CM1',
        'CM2'

    ];


       public static function classroomName(){
        return static::randomElement(static::$names);
    }

    
        
    

   
}