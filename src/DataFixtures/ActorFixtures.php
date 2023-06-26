<?php

namespace App\DataFixtures;

use App\DataFixtures\ProgramFixtures;
use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($i = 0; $i < 10; $i++) {
            $actor = new Actor();
            $actor->setName($faker->name());

            for ($j = 0; $j < 3; $j++) {
                $randomProgramIndex = $faker->numberBetween(0, 29);
                $actor->addProgram($this->getReference('program_' . $randomProgramIndex));
            }
            $manager->persist($actor);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
          ProgramFixtures::class,
        ];
    }
}