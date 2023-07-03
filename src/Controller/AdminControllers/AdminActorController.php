<?php

namespace App\Controller\AdminControllers;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ActorType;
use App\Repository\ActorRepository;
use App\Repository\CategoryRepository;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/admin/actor')]
#[IsGranted('ROLE_ADMIN')]

class AdminActorController extends AbstractController
{
    #[Route('/', name: 'admin_actor_index', methods: ['GET'])]
    public function index(ActorRepository $actorRepository): Response
    {
        return $this->render('admin/actor/index.html.twig', [
            'actors' => $actorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_actor_new', methods: ['GET', 'POST'])] 
    public function new(Request $request, ActorRepository $actorRepository, SluggerInterface $slugger) : Response
    {
        $actor = new Actor();
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($actor->getName());
            $actor->setSlug($slug);
            $actorRepository->save($actor, true);
            $this->addFlash('success', 'The new actor file has been created');

            return $this->redirectToRoute('admin_actor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/actor/new.html.twig', [
            'actor' => $actor,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', requirements: ['page' => '\d+'], name: 'admin_actor_show', methods: ['GET'])]
    public function show(Actor $actor): Response
    {
        return $this->render('admin/actor/show.html.twig', [
            'actor' => $actor,
        ]);
    }

    #[Route('/{slug}/edit', name: 'admin_actor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Actor $actor, ActorRepository $actorRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($actor->getName());
            $actor->setSlug($slug);
            $actorRepository->save($actor, true);
            $this->addFlash('success', 'The actor file has been updated successfully');

            return $this->redirectToRoute('admin_actor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/actor/edit.html.twig', [
            'actor' => $actor,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'admin_actor_delete', methods: ['POST'])]
    public function delete(Request $request, Actor $actor, ActorRepository $actorRepository, SluggerInterface $slugger): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actor->getSlug(), $request->request->get('_token'))) {
            $actorRepository->remove($actor, true);

            $this->addFlash('danger', 'The actor file has been deleted');
        }

        return $this->redirectToRoute('admin_actor_index', [], Response::HTTP_SEE_OTHER);
    }
}