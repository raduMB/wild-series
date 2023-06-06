<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public const EPISODES =[
        [
            'reference' => 'season 1_The Boys',
            'title' => 'The Name of the Game',
            'number' => '1',
            'synopsis' => 'When a Supe kills the love of his life, A/V salesman Hughie Campbell teams up with Billy Butcher, a vigilante hell-bent on punishing corrupt Supes -- and Hughie\'s life will never be the same again.',
        ],
        [
            'reference' => 'season 1_The Boys',
            'title' => 'Cherry',
            'number' => '2',
            'synopsis' => 'The Boys get themselves a Superhero, Starlight gets payback, Homelander gets naughty, and a Senator gets naughtier.',
        ],
        [
            'reference' => 'season 1_The Boys',
            'title' => 'Get Some',
            'number' => '3',
            'synopsis' => 'It\'s the race of the century. A-Train versus Shockwave, vying for the title of World\'s Fastest Man. Meanwhile, the Boys are reunited and it feels so good.',
        ],
        [
            'reference' => 'season 2_The Boys',
            'title' => 'The Big Ride',
            'number' => '1',
            'synopsis' => 'With Butcher still missing, Hughie, Mother\'s Milk, Frenchie, and Kimiko are now fugitives, and Homelander and Vought are more powerful than ever. But just as the Boys are about to leave the country, they are pulled back into the fray.',
        ],
        [
            'reference' => 'season 2_The Boys',
            'title' => 'Proper Preparation and Planning',
            'number' => '2',
            'synopsis' => 'Butcher is back with the Boys, but tensions flare with Hughie. Homelander spends quality time with his new "family." Starlight and Stormfront bond at a press junket and the Boys hunt down a super terrorist with a startling identity.',
        ],
        [
            'reference' => 'season 2_The Boys',
            'title' => 'Over the Hill with the Swords of a Thousand Men',
            'number' => '3',
            'synopsis' => 'The Boys take to the high seas to safeguard their prisoner. Homelander plays house, then pushes Ryan over the edge. Starlight is forced to make an impossible choice. Stormfront reveals her true character.',
        ],
        [
            'reference' => 'season 3_The Boys',
            'title' => 'Payback',
            'number' => '1',
            'synopsis' => 'One year following Stormfront\'s public controversy, Butcher and the Boys now work as contractors for Neuman\'s Bureau of Superhero Affairs in order to apprehend problematic Supes, with Hughie acting as their liaison.',
        ],
        [
            'reference' => 'season 3_The Boys',
            'title' => 'The Only Man in the Sky',
            'number' => '2',
            'synopsis' => 'Homelander, America\'s greatest Supe. Defending our shores from sea to shining sea. Today, America honors him on his birthday. Vought Shopping Network is celebrating by offering an exclusive Homelander Limited Birthday Edition Gold Coin.',
        ],
        [
            'reference' => 'season 3_The Boys',
            'title' => 'Barbary Coast',
            'number' => '3',
            'synopsis' => 'Tonight at 9/8C on Vought Plus, it\'s the season finale of #AmericanHero. Three contestants remain, but only TWO will join #TheSeven. Will Starlight choose her old flame Supersonic? Or will someone else be moving into the Seven Tower?',
        ],
        [
            'reference' => 'season 1_Vikings',
            'title' => 'Rites of Passage',
            'number' => '1',
            'synopsis' => 'Ragnar goes on a trip of initiation with his son. Meanwhile, he thinks he has finally found a way to sail ships to the west. However, his beliefs are seen as insane so he chooses to go against the law.',
        ],
        [
            'reference' => 'season 1_Vikings',
            'title' => 'Wrath of the Northmen',
            'number' => '2',
            'synopsis' => 'The stage is set for the first journey west by Ragnar Lothbrok as he gathers a crew willing to risk their lives to travel into the unknown.',
        ],
        [
            'reference' => 'season 1_Vikings',
            'title' => 'Dispossessed',
            'number' => '3',
            'synopsis' => 'After his successful raid, Ragnar and his crew joyously return home with their riches. Earl Haraldson doesn\'t hesitate to summon Ragnar to the great hall where he lays claim to the entirety of the treasure.',
        ],
        [
            'reference' => 'season 2_Vikings',
            'title' => 'Brother\'s War',
            'number' => '1',
            'synopsis' => 'The battle begins between Ragnar and King Horik\'s forces against Jarl Borg. Borg is joined by Rollo, and this Viking clash pits brother against brother.',
        ],
        [
            'reference' => 'season 2_Vikings',
            'title' => 'Invasion',
            'number' => '2',
            'synopsis' => 'Four peaceful years have since passed with Ragnar as Earl. The time has come for an unlikely alliance to band together in pursuit of a common goal - a new raid on England.',
        ],
        [
            'reference' => 'season 2_Vikings',
            'title' => 'Treachery',
            'number' => '3',
            'synopsis' => 'The Wessex Viking raid is in full swing and King Ecbert finds himself facing an entirely new kind of foe',
        ],
        [
            'reference' => 'season 3_Vikings',
            'title' => 'Mercenary',
            'number' => '1',
            'synopsis' => 'Ragnar and Lagertha\'s fleets depart Kattegat once more for Wessex but this time they bring settlers.',
        ],
        [
            'reference' => 'season 3_Vikings',
            'title' => 'The Wanderer',
            'number' => '2',
            'synopsis' => 'Lagertha and Athelstan help to set up the Viking settlement; a mysterious wanderer turns up.',
        ],
        [
            'reference' => 'season 3_Vikings',
            'title' => 'Warrior\'s Fate',
            'number' => '3',
            'synopsis' => 'King Ecbert visits the developing Viking settlement as the first harvest is sown.',
        ],
        [
            'reference' => 'season 1_South Park',
            'title' => 'Unaired Pilot',
            'number' => '1',
            'synopsis' => 'Cartman wakes up and realizes he was abducted by aliens after hearing it from his friends. He is in major denial at first though, but even Chef is a believer.',
        ],
        [
            'reference' => 'season 1_South Park',
            'title' => 'Cartman Gets an Anal Probe',
            'number' => '2',
            'synopsis' => 'Cartman\'s dream about being abducted by aliens turns out to have actually happened, and when the aliens take Kyle\'s brother, all of them must find a way to bring the aliens back and confront them.',
        ],
        [
            'reference' => 'season 1_South Park',
            'title' => 'Weight Gain 4000',
            'number' => '3',
            'synopsis' => 'Kathie Lee Gifford comes to South Park to present an award to Cartman, and Mr. Garrison hopes to use the event to assassinate her.',
        ],
        [
            'reference' => 'season 2_South Park',
            'title' => 'Terrance and Phillip in Not Without My Anus',
            'number' => '1',
            'synopsis' => 'Terrance and Phillip must go to Iran to rescue Terrance\'s kidnapped daughter. Meanwhile Saddam Hussein takes over Canada.',
        ],
        [
            'reference' => 'season 2_South Park',
            'title' => 'Cartman\'s Mom is Still a Dirty Slut',
            'number' => '2',
            'synopsis' => 'The boys get snowed in at the hospital while waiting to learn the identity of Cartman\'s father. Meanwhile, the townspeople resort to cannibalism when they get snowed in.',
        ],
        [
            'reference' => 'season 2_South Park',
            'title' => 'Chickenlover',
            'number' => '3',
            'synopsis' => 'Mr. Barbrady goes back to school after it is discovered that he is illiterate. As he learns to read, a criminal is on the loose molesting all the chickens in South Park.',
        ],
        [
            'reference' => 'season 3_South Park',
            'title' => 'Rainforest Shmainforest',
            'number' => '1',
            'synopsis' => 'The gang gets lost in the rain forest after going to Costa Rica with a singing tour.',
        ],
        [
            'reference' => 'season 3_South Park',
            'title' => 'Spontaneous Combustion',
            'number' => '2',
            'synopsis' => 'Randy Marsh becomes a national hero after he discovers the reason why South Park residents are spontaneously combusting. Meanwhile, Kyle and Stan have a plan to help Kyle\'s dad get a res-erection.',
        ],
        [
            'reference' => 'season 3_South Park',
            'title' => 'The Succubus',
            'number' => '3',
            'synopsis' => 'The boys try to save Chef from a woman who is stealing him from them. Meanwhile, Cartman gets glasses.',
        ],
        
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::EPISODES as $key => $episodeValue) {
            $episode = new Episode();
            $episode->setSeason($this->getReference($episodeValue['reference']));
            $episode->setTitle($episodeValue['title']);
            $episode->setNumber($episodeValue['number']);
            $episode->setSynopsis($episodeValue['synopsis']);
            $manager->persist($episode);
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