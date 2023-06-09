<?php

namespace App\DataFixtures;

use App\DataFixtures\CategoryFixtures;
use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

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
            $program->setSlug($this->slugger->slug($program->getTitle()));
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