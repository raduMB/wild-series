<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Episode;
use App\DataFixtures\SeasonFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($i = 0; $i < 900; $i++) {
            $episode = new Episode();
            $episode->setTitle($faker->sentence());
            $episode->setSynopsis($faker->paragraphs(3, true));
            $episode->setNumber($faker->numberBetween(1, 899));
            $episode->setSeason($this->getReference('season_' . $faker->numberBetween(1, 89)));
            $manager->persist($episode);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          SeasonFixtures::class,
        ];
    }
}