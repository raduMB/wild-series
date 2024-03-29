<?php

namespace App\Controller\AdminControllers;

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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/admin/program')]
#[IsGranted('ROLE_ADMIN')]

class AdminProgramController extends AbstractController
{
    #[Route('/', name: 'admin_program_index', methods: ['GET', 'POST'])]
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

        return $this->render('admin/program/index.html.twig', [
            'programs' => $programs,
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'admin_program_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MailerInterface $mailer, ProgramRepository $programRepository, SluggerInterface $slugger): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($program->getTitle());
            $program->setSlug($slug);
            $program->setOwner($this->getUser());
            $programRepository->save($program, true);
            
            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to('your_email@example.com')
                ->subject('Une nouvelle série vient d\'être publiée !')
                ->html($this->renderView('admin/program/newProgramEmail.html.twig', ['program' => $program]));
            $mailer->send($email);

            $this->addFlash('success', 'The new program has been created');

            return $this->redirectToRoute('admin_program_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/program/new.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', requirements: ['page' => '\d+'], name: 'admin_program_show', methods: ['GET'])]
    public function show(Program $program, ProgramDuration $programDuration): Response
    {
        return $this->render('admin/program/show.html.twig', [
            'program' => $program,
            'programDuration' => $programDuration->calculate($program),
        ]);
    }

    #[Route('/{slug}/edit', name: 'admin_program_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Program $program, ProgramRepository $programRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($program->getTitle());
            $program->setSlug($slug);
            if ($this->getUser() !== $program->getOwner()) {
                // If not the owner, throws a 403 Access Denied exception
                throw $this->createAccessDeniedException('Only the owner can edit the program!');
            }
            $programRepository->save($program, true);
            $this->addFlash('success', 'The program has been updated successfully');

            return $this->redirectToRoute('admin_program_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/program/edit.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'admin_program_delete', methods: ['POST'])]
    public function delete(Request $request, Program $program, ProgramRepository $programRepository, SluggerInterface $slugger): Response
    {
        if ($this->isCsrfTokenValid('delete'.$program->getSlug(), $request->request->get('_token'))) {
            if ($this->getUser() !== $program->getOwner()) {
                // If not the owner, throws a 403 Access Denied exception
                throw $this->createAccessDeniedException('Only the owner can delete the program!');
            }
            $programRepository->remove($program, true);

            $this->addFlash('danger', 'The program has been deleted');
        }

        return $this->redirectToRoute('admin_program_index', [], Response::HTTP_SEE_OTHER);
    }
}