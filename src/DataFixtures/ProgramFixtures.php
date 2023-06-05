<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAMS =[
        [
            'title' => 'Fun with Dick and Jane',
            'synopsis' => 'Lorsqu\'un couple aisé perd tout son argent à la suite d\'une série de gaffes, il se tourne vers une vie de crime pour joindre les deux bouts.',
            'reference' => 'category_Action',
        ],
        [
            'title' => 'Me, Myself & Irene',
            'synopsis' => 'Un gentil flic atteint d\'un trouble dissociatif de l\'identité doit protéger une femme en fuite d\'un ex-petit ami corrompu et de ses associés.',
            'reference' => 'category_Aventure',
        ],
        [
            'title' => 'How the Grinch Stole Christmas',
            'synopsis' => 'À la périphérie de Whoville vit un Grinch vert et vengeur qui prévoit de gâcher Noël pour tous les citoyens de la ville.',
            'reference' => 'category_Animation',
        ],
        [
            'title' => 'Man on the Moon',
            'synopsis' => 'The life and career of legendary comedian Andy Kaufman.',
            'reference' => 'category_Biographique',
        ],
        [
            'title' => 'Ace Ventura: Pet Detective',
            'synopsis' => 'Détective spécialisé dans la recherche d\'animaux perdus, Ace Ventura habite un appartement devenu une véritable arche de Noé où se côtoient caméléon, perroquet, canari et mouffette.',
            'reference' => 'category_Comedie',
        ],
        [
            'title' => 'The Majestic',
            'synopsis' => 'En 1951, un écrivain hollywoodien mis à l\'index a un accident de voiture, perd la mémoire et s\'installe dans une petite ville où il est pris pour un fils perdu depuis longtemps.',
            'reference' => 'category_Drame',
        ],
        [
            'title' => 'Eternal Sunshine of the Spotless Mind',
            'synopsis' => 'Lorsque leur relation tourne au vinaigre, un couple subit une intervention médicale pour s\'effacer à jamais de leur mémoire.',
            'reference' => 'category_Fantastique',
        ],
        [
            'title' => 'The Number 23',
            'synopsis' => 'Walter Sparrow devient obsédé par un roman qui, selon lui, a été écrit sur lui, alors que de plus en plus de similitudes entre lui et son alter ego littéraire semblent surgir.',
            'reference' => 'category_Horreur',
        ],
        [
            'title' => 'Batman Forever',
            'synopsis' => 'Batman doit combattre l\'ancien procureur de district Harvey Dent, qui est maintenant Two-Face et Edward Nygma, The Riddler avec l\'aide d\'un psychologue amoureux et d\'un jeune acrobate de cirque qui devient son acolyte, Robin.',
            'reference' => 'category_Merde',
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $key => $programValue) {
            $program = new Program();
            $program->setTitle($programValue['title']);
            $program->setSynopsis($programValue['synopsis']);
            $program->setCategory($this->getReference($programValue['reference']));
            $manager->persist($program);
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