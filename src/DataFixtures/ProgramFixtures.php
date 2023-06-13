<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Program;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        
        for($i = 0; $i < 30; $i++) {
            $program = new Program();
            $program->setTitle($faker->sentence());
            $program->setSynopsis($faker->realText($maxNbChars = 200, $indexSize = 2));
            $program->setPoster($faker->image(null, 640, 480));
            $program->setCountry($faker->country());
            $program->setYear($faker->year());
            $randomCategoryKey = array_rand(CategoryFixtures::CATEGORIES);
            $categoryName = CategoryFixtures::CATEGORIES[$randomCategoryKey];
            $program->setCategory($this->getReference('category_' . $categoryName));
            $this->addReference('program_' . $i, $program);
            $manager->persist($program);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
          CategoryFixtures::class,
        ];
    }

}