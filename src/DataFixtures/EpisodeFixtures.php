<?php

namespace App\DataFixtures;

use App\DataFixtures\SeasonFixtures;
use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($i = 0; $i < 900; $i++) {
            $episode = new Episode();
            $episode->setTitle($faker->sentence());
            $episode->setSynopsis($faker->paragraphs(3, true));
            $episode->setNumber($faker->numberBetween(1, 899));
            $episode->setDuration($faker->randomNumber(2));
            $episode->setSlug($this->slugger->slug($episode->getTitle()));
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