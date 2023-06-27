<?php

namespace App\Controller\AppControllers;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\SeasonType;
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

#[Route('/app/season')]

class AppSeasonController extends AbstractController
{
    #[Route('/{slug}/season/{season}', name: 'app_season_show', methods: ['GET'])]
    
    public function show(Program $program, Season $season, EpisodeRepository $episodeRepository): Response
    {
        
        $episodes = $episodeRepository->findBy(['season' => $season]);

        return $this->render('app/season/show.html.twig', ['program' => $program, 'season' => $season, 'episodes' => $episodes]);

    }
}