<?php

namespace App\DataFixtures;

use App\DataFixtures\ProgramFixtures;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($i = 0; $i < 90; $i++) {
            $season = new Season();
            $season->setNumber($faker->numberBetween(1, 4));
            $season->setYear($faker->year());
            $season->setDescription($faker->realTextBetween($minNbChars = 160, $maxNbChars = 200, $indexSize = 2));
            $season->setProgram($this->getReference('program_' . $faker->numberBetween(0, 29)));
            $season->setSlug($this->slugger->slug($season->getNumber()));
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