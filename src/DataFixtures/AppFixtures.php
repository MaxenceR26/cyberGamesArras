<?php

namespace App\DataFixtures;

use App\Entity\Machines;
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
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i=0;$i <= 49; $i++) { 
            $machines = new Machines();
            $machines->setName($this->faker->word())
                ->setGames('Jeux ' . $i)
                ->setAddress('192.168.1.' . $i);
                $manager->persist($machines);
        }

        $manager->flush();
    }
}
