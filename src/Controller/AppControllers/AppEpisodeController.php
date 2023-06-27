<?php

namespace App\Controller\AppControllers;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\EpisodeType;
use App\Repository\ActorRepository;
use App\Repository\CategoryRepository;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/app/episode')]

class AppEpisodeController extends AbstractController
{
    #[Route('/{slug}/season/{season}/episode/{episode}', name: 'app_episode_show', methods: ['GET'])]
    #[Entity('episode', options: ['mapping' => ['episode' => 'slug']])]
    public function show(Program $program, Season $season, Episode $episode)
    {
        return $this->render('app/episode/show.html.twig', ['program' => $program, 'season' => $season, 'episode' => $episode]);

    }
}