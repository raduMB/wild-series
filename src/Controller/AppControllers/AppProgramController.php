<?php

namespace App\Controller\AppControllers;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
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

#[Route('/app/program')]

class AppProgramController extends AbstractController
{
    #[Route('/', name: 'app_program_index', methods: ['GET'])]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render('app/program/index.html.twig', [
            'programs' => $programs,
        ]);
    }

    #[Route('/{id}', requirements: ['page' => '\d+'], name: 'app_program_show', methods: ['GET'])]
    public function show(Program $program): Response
    {
        $seasons = $program->getSeasons();

        if (!$program) {
            throw $this->createNotFoundException(
                'Aucune série avec le n° : '.$program->getId().' n\'a pas été trouvée dans la liste.'
            );
        }

        return $this->render('app/program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
        ]);
    }
}