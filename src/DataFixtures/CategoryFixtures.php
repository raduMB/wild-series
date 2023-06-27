<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    const CATEGORIES = [
        'Action',
        'Aventure',
        'Animation',
        'Comédie',
        'Drame',
        'Fantastique',
        'Horreur',
        'Pourquoi Bon Dieu',
        'Policier',
        'Science-Fiction',
    ];

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $key => $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $category->setSlug($this->slugger->slug($category->getName()));
            $this->addReference('category_' . $categoryName, $category);
            $manager->persist($category);
        }
        $manager->flush();
    }
}