<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Season;
use App\DataFixtures\ProgramFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($i = 0; $i < 90; $i++) {
            $season = new Season();
            $season->setNumber($faker->numberBetween(1, 4));
            $season->setYear($faker->year());
            $season->setDescription($faker->realTextBetween($minNbChars = 160, $maxNbChars = 200, $indexSize = 2));
            $season->setProgram($this->getReference('program_' . $faker->numberBetween(0, 29)));
            $this->addReference('season_' . $i, $season);
            $manager->persist($season);
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