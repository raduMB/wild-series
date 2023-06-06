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
            'title' => 'The Boys',
            'synopsis' => 'Une histoire d\'action centrée sur une équipe de la CIA chargée de maintenir les super-héros en ligne, par tous les moyens nécessaires.',
            'reference' => 'category_Action',
        ],
        [
            'title' => 'Vikings',
            'synopsis' => 'Vikings nous transporte dans le monde brutal et mystérieux de Ragnar Lothbrok, un guerrier et fermier viking qui aspire à explorer (et à attaquer) les rives lointaines au large de l\'océan.',
            'reference' => 'category_Aventure',
        ],
        [
            'title' => 'South Park',
            'synopsis' => 'Suit les mésaventures de quatre collégiens insolents dans la ville tranquille et dysfonctionnelle de South Park dans le Colorado.',
            'reference' => 'category_Animation',
        ],
        [
            'title' => 'The Crown',
            'synopsis' => 'Suit les rivalités politiques et l\'histoire du règne de la reine Elizabeth II et les événements qui ont marqué la seconde moitié du XXème siècle.',
            'reference' => 'category_Biographique',
        ],
        [
            'title' => 'Seinfeld',
            'synopsis' => 'Les mésaventures continues de Jerry Seinfeld, humoriste névrosé et de ses amis new-yorkais.',
            'reference' => 'category_Comedie',
        ],
        [
            'title' => 'Planet Earth',
            'synopsis' => 'Récompensée par un Emmy Award, onze épisodes, cinq ans de préparation, la série documentaire sur la nature la plus chère jamais commandée par la BBC et la première à être filmée en haute définition.',
            'reference' => 'category_Documentaire',
        ],
        [
            'title' => 'Mad Men',
            'synopsis' => 'Un drame sur l\'une des agences de publicité les plus prestigieuses de New York au début des années 1960, mettant l\'accent sur Donald Draper, l\'un des directeurs de publicité les plus mystérieux mais extrêmement talentueux.',
            'reference' => 'category_Drame',
        ],
        [
            'title' => 'Twin Peaks',
            'synopsis' => 'Un agent du FBI singulier enquête sur le meurtre d\'une jeune femme dans la ville encore plus singulière de Twin Peaks.',
            'reference' => 'category_Fantastique',
        ],
        [
            'title' => 'Chernobyl',
            'synopsis' => 'En avril 1986, une explosion à la centrale nucléaire de Tchernobyl en URSS, devient l\'une des pires catastrophes causées par l\'homme au monde.',
            'reference' => 'category_Historique',
        ],
        [
            'title' => 'Stranger Things',
            'synopsis' => 'Lorsqu\'un jeune garçon disparaît, sa mère, le chef de police et ses amis doivent affronter des forces terrifiantes afin de le retrouver.',
            'reference' => 'category_Horreur',
        ],
        [
            'title' => 'Melrose Place',
            'synopsis' => 'La série classique d\'un groupe d\'amis vivant à Melrose Place, en Californie.',
            'reference' => 'category_Merde',
        ],
        [
            'title' => 'True Detective',
            'synopsis' => 'Série dans laquelle les enquêtes policières dénichent les secrets personnels et professionnels des personnes impliquées dans la loi ou non.',
            'reference' => 'category_Policier',
        ],
        [
            'title' => 'The Expanse',
            'synopsis' => 'L\'état fragile de guerre froide du système solaire est menacé alors qu\'une vaste conspiration est lentement découverte.',
            'reference' => 'category_Science-fiction',
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $key => $programValue) {
            $program = new Program();
            $program->setTitle($programValue['title']);
            $program->setSynopsis($programValue['synopsis']);
            $program->setCategory($this->getReference($programValue['reference']));
            $this->addReference('program_' . $programValue['title'], $program);
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