<?php

namespace App\Controller\AdminControllers;

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

#[Route('/admin/season')]

class AdminSeasonController extends AbstractController
{
    #[Route('/', name: 'admin_season_index', methods: ['GET'])]
    public function index(SeasonRepository $seasonRepository): Response
    {
        return $this->render('admin/season/index.html.twig', [
            'seasons' => $seasonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_season_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SeasonRepository $seasonRepository, SluggerInterface $slugger): Response
    {
        $season = new Season();
        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($season->getNumber());
            $season->setSlug($slug);
            $seasonRepository->save($season, true);
            $this->addFlash('success', 'The new season has been created');

            return $this->redirectToRoute('admin_season_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/season/new.html.twig', [
            'season' => $season,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', requirements: ['page' => '\d+'], name: 'admin_season_show', methods: ['GET'])]
    public function show(Season $season): Response
    {
        return $this->render('admin/season/show.html.twig', [
            'season' => $season,
        ]);
    }

    #[Route('/{slug}/edit', name: 'admin_season_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Season $season, SeasonRepository $seasonRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($season->getNumber());
            $season->setSlug($slug);
            $seasonRepository->save($season, true);
            $this->addFlash('success', 'The season has been updated successfully');

            return $this->redirectToRoute('admin_season_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/season/edit.html.twig', [
            'season' => $season,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'admin_season_delete', methods: ['POST'])]
    public function delete(Request $request, Season $season, SeasonRepository $seasonRepository, SluggerInterface $slugger): Response
    {
        if ($this->isCsrfTokenValid('delete'.$season->getSlug(), $request->request->get('_token'))) {
            $seasonRepository->remove($season, true);

            $this->addFlash('danger', 'The season has been deleted');
        }

        return $this->redirectToRoute('admin_season_index', [], Response::HTTP_SEE_OTHER);
    }
}
