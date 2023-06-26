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

#[Route('/app/season')]

class AppSeasonController extends AbstractController
{
    #[Route('/{programId}/seasons/{seasonId}', requirements: ['programId' => '\d+', 'seasonId' => '\d+'], name: 'app_season_show', methods: ['GET'])]
    #[Entity('program', expr: 'repository.find(programId)')]
    #[Entity('season', expr: 'repository.find(seasonId)')]
    public function show(Program $program, Season $season, EpisodeRepository $episodeRepository): Response
    {
        
        $episodes = $episodeRepository->findBy(['season' => $season]);

        if (!$program) {
            throw $this->createNotFoundException(
                'Aucune série avec le n° : '.$program->getId().' n\'a pas été trouvée dans la liste des séries.'
            );
        }

        if (!$season) {
            throw $this->createNotFoundException(
                'Aucune saison avec le n° : '.$season->getId().' n\'a pas été trouvée dans la liste des saisons.'
            );
        }
        
        return $this->render('app/season/show.html.twig', [
            'programs' => $program, 'seasons' => $season, 'episodes' => $episodes,
        ]);
    }
}