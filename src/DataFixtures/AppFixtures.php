<?php

namespace App\DataFixtures;

use App\Entity\Token;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    /*
    * @var Generator
    */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('en_US');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i=0;$i <= 20; $i++) { 
            $machines = new Token();
            $machines->setToken($this->faker->phoneNumberWithExtension());
            $manager->persist($machines);
        }

        $manager->flush();
    }
}
