<?php

namespace App\Controller\AdminControllers;

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

#[Route('/admin/program')]

class AdminProgramController extends AbstractController
{
    #[Route('/', name: 'admin_program_index', methods: ['GET'])]
    public function index(ProgramRepository $programRepository): Response
    {
        return $this->render('admin/program/index.html.twig', [
            'programs' => $programRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_program_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProgramRepository $programRepository) : Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $programRepository->save($program, true);

            $this->addFlash('success', 'The new program has been created');

            return $this->redirectToRoute('admin_program_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/program/new.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_program_show', methods: ['GET'])]
    public function show(Program $program): Response
    {
        return $this->render('admin/program/show.html.twig', [
            'program' => $program,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_program_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Program $program, ProgramRepository $programRepository): Response
    {
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $programRepository->save($program, true);

            $this->addFlash('success', 'The program has been updated successfully');

            return $this->redirectToRoute('admin_program_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/program/edit.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_program_delete', methods: ['POST'])]
    public function delete(Request $request, Program $program, ProgramRepository $programRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$program->getId(), $request->request->get('_token'))) {
            $programRepository->remove($program, true);

            $this->addFlash('danger', 'The program has been deleted');
        }

        return $this->redirectToRoute('admin_program_index', [], Response::HTTP_SEE_OTHER);
    }
}