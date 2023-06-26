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

#[Route('/app/actor')]

class AppActorController extends AbstractController
{
    #[Route('/', name: 'app_actor_index', methods: ['GET'])]
    public function index(ActorRepository $actorRepository): Response
    {
        $actors = $actorRepository->findAll();

        return $this->render('app/actor/index.html.twig', [
            'actors' => $actors,
        ]);
    }

    #[Route('/{id}', requirements: ['page' => '\d+'], name: 'app_actor_show', methods: ['GET'])]
    public function show(Actor $actor): Response
    {
        $programs = $actor->getPrograms();

        if (!$actor) {
            throw $this->createNotFoundException(
                'Aucune actor avec le nom : '.$actor->getName().' n\'a pas été trouvée dans la liste.'
            );
        }

        return $this->render('app/actor/show.html.twig', [
            'actor' => $actor,
            'programs' => $programs,
        ]);
    }
}