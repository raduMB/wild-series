<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public const SEASONS =[
        [
            'reference' => 'program_The Boys',
            'number' => '1',
            'year' => '2019',
            'description' => 'First Season',
        ],
        [
            'reference' => 'program_The Boys',
            'number' => '2',
            'year' => '2020',
            'description' => 'Second Season',
        ],
        [
            'reference' => 'program_The Boys',
            'number' => '3',
            'year' => '2022',
            'description' => 'Third Season',
        ],
        [
            'reference' => 'program_Vikings',
            'number' => '1',
            'year' => '2013',
            'description' => 'First Season',
        ],
        [
            'reference' => 'program_Vikings',
            'number' => '2',
            'year' => '2014',
            'description' => 'Second Season',
        ],
        [
            'reference' => 'program_Vikings',
            'number' => '3',
            'year' => '2015',
            'description' => 'Third Season',
        ],
        [
            'reference' => 'program_South Park',
            'number' => '1',
            'year' => '1997',
            'description' => 'First Season',
        ],
        [
            'reference' => 'program_South Park',
            'number' => '2',
            'year' => '1998',
            'description' => 'Second Season',
        ],
        [
            'reference' => 'program_South Park',
            'number' => '3',
            'year' => '1999',
            'description' => 'Third Season',
        ],
        
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::SEASONS as $key => $seasonValue) {
            $season = new Season();
            $season->setProgram($this->getReference($seasonValue['reference']));
            $season->setNumber($seasonValue['number']);
            $season->setYear($seasonValue['year']);
            $season->setDescription($seasonValue['description']);
            $this->addReference('season_' . $seasonValue['number'], $season);
            $manager->persist($season);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          CategoryFixtures::class,
        ];
    }

}