<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProgramRepository $programRepository) : Response
    {
        // Create a new Program Object
        $program = new Program();

        // Create the form, linked with $program
        $form = $this->createForm(ProgramType::class, $program);

        // Get data from HTTP request
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $programRepository->save($program, true);

            // Redirect to programs list
            return $this->redirectToRoute('program_index');
        }

        // Render the form
        return $this->render('program/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', requirements: ['page' => '\d+'], name: 'show', methods: ['GET'])]
    public function show(Program $program): Response
    {
        $seasons = $program->getSeasons();

        if (!$program) {
            throw $this->createNotFoundException(
                'Aucune série avec le n° : '.$program->getId().' n\'a pas été trouvée dans la liste.'
            );
        }

        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
        ]);
    }

    #[Route('/{programId}/seasons/{seasonId}', requirements: ['programId' => '\d+', 'seasonId' => '\d+'], name: 'season_show', methods: ['GET'])]
    public function showSeason(#[MapEntity(mapping: ['programId' => 'id'])] Program $program, #[MapEntity(mapping: ['seasonId' => 'id'])]  Season $season, EpisodeRepository $episodeRepository): Response
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
        
        return $this->render('program/season_show.html.twig', [
            'programs' => $program, 'seasons' => $season, 'episodes' => $episodes,
        ]);
    }

    #[Route('/{programId}/seasons/{seasonId}/episodes/{episodeId}', requirements: ['programId' => '\d+', 'seasonId' => '\d+', 'episodeId' => '\d+'], name: 'episode_show', methods: ['GET'])]
    public function showEpisode(#[MapEntity(mapping: ['programId' => 'id'])] Program $program, #[MapEntity(mapping: ['seasonId' => 'id'])] Season $season, #[MapEntity(mapping: ['episodeId' => 'id'])] Episode $episode): Response
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
        
        return $this->render('program/episode_show.html.twig', [
            'programs' => $program, 'seasons' => $season, 'episodes' => $episode,
        ]);
    }
}