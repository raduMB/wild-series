<?php

namespace App\Controller;

use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/program', name: 'program_')]

class ProgramController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render('program/index.html.twig', [
            'programs' => $programs,
        ]);
    }

    #[Route('/{id}', requirements: ['page' => '\d+'], name: 'show', methods: ['GET'])]
    public function show(int $id, ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->find($id);

        if (!$programs) {
            throw $this->createNotFoundException(
                'Aucune série avec le n° : '.$id.' n\'a pas été trouvée dans la liste.'
            );
        }

        return $this->render('program/show.html.twig', [
            'programs' => $programs,
        ]);
    }

    #[Route('/{programId}/seasons/{seasonId}', requirements: ['programId' => '\d+', 'seasonId' => '\d+'], name: 'season_show', methods: ['GET'])]
    public function showSeason(int $programId, int $seasonId, ProgramRepository $programRepository, SeasonRepository $seasonRepository, EpisodeRepository $episodeRepository): Response
    {
        $program = $programRepository->find($programId);
        $season = $seasonRepository->find($seasonId);
        $episodes = $season->getEpisodes();

        if (!$program) {
            throw $this->createNotFoundException(
                'Aucune série avec le n° : '.$programId.' n\'a pas été trouvée dans la liste des séries.'
            );
        }

        if (!$season) {
            throw $this->createNotFoundException(
                'Aucune saison avec le n° : '.$seasonId.' n\'a pas été trouvée dans la liste des saisons.'
            );
        }
        
        return $this->render('program/season_show.html.twig', [
            'program' => $program, 'season' => $season, 'episodes' => $episodes,
        ]);
    }

}