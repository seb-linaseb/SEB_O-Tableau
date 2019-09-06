<?php

//src/DataFixtures/MyCustomNativeLoader.php

namespace App\DataFixtures;

use Nelmio\Alice\Loader\NativeLoader;
use Faker\Generator as FakerGenerator;


//ajout du provider custom
use App\DataFixtures\Faker\RoleProvider;
use App\DataFixtures\Faker\SchoolProvider;
use Faker\Factory as FakerGeneratorFactory;
use App\DataFixtures\Faker\ClassroomProvider;
use App\DataFixtures\Faker\LunchTypeProvider;
use Nelmio\Alice\Faker\Provider\AliceProvider;

class MyCustomNativeLoader extends NativeLoader
{
    protected function createFakerGenerator(): FakerGenerator
    {
        $generator = FakerGeneratorFactory::create(parent::LOCALE);
        $generator->addProvider(new AliceProvider());

        //ajout du nouveau provider en passant le generator dans le constructeur de notre classe (heritée du parent base)
        $generator->addProvider(new RoleProvider($generator));
        $generator->addProvider(new SchoolProvider($generator));
        $generator->addProvider(new ClassroomProvider($generator));
        $generator->addProvider(new LunchTypeProvider($generator));
        $generator->seed($this->getSeed());

        return $generator;
    }
}