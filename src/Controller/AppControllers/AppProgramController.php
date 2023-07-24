<?php

namespace App\Controller\AppControllers;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Form\SearchProgramType;
use App\Repository\ActorRepository;
use App\Repository\CategoryRepository;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Service\ProgramDuration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/app/program')]

class AppProgramController extends AbstractController
{
    #[Route('/', name: 'app_program_index', methods: ['GET', 'POST'])]
    public function index(Request $request, ProgramRepository $programRepository): Response
    {
        $form = $this->createForm(SearchProgramType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];
            $programs = $programRepository->findLikeName($form->getData()['search']);
        } else {
            $programs = $programRepository->findAll();
        }

        return $this->render('app/program/index.html.twig', [
            'programs' => $programs,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', requirements: ['page' => '\d+'], name: 'app_program_show', methods: ['GET'])]
    public function show(Program $program, ProgramDuration $programDuration): Response
    {
        $seasons = $program->getSeasons();
        $duration = $programDuration->calculate($program);

        return $this->render('app/program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
            'duration' => $duration,
        ]);
    }
}