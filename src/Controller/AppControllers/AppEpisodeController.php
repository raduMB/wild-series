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

#[Route('/app/episode')]

class AppEpisodeController extends AbstractController
{
    #[Route('/{programId}/seasons/{seasonId}/episodes/{episodeId}', requirements: ['programId' => '\d+', 'seasonId' => '\d+', 'episodeId' => '\d+'], name: 'app_episode_show', methods: ['GET'])]
    #[Entity('program', expr: 'repository.find(programId)')]
    #[Entity('season', expr: 'repository.find(seasonId)')]
    #[Entity('episode', expr: 'repository.find(episodeId)')]
    public function show(Program $program, Season $season, Episode $episode): Response
    {
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

        if (!$episode) {
            throw $this->createNotFoundException(
                'Aucun épisode avec le n° : '.$episode->getId().' n\'a pas été trouvée dans la liste des épisodes.'
            );
        }
        
        return $this->render('app/episode/show.html.twig', [
            'programs' => $program, 'seasons' => $season, 'episodes' => $episode,
        ]);
    }
}