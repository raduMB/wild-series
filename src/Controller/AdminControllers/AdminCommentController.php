<?php

namespace App\Controller\AdminControllers;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\EpisodeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/admin/comment')]
#[IsGranted('ROLE_ADMIN')]

class AdminCommentController extends AbstractController
{
    #[Route('/', name: 'admin_comment_index', methods: ['GET'])]
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('admin/comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'admin_comment_show', methods: ['GET'])]
    public function show(Comment $comment): Response
    {
        return $this->render('admin/comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_comment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comment $comment, CommentRepository $commentRepository): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentRepository->save($comment, true);

            return $this->redirectToRoute('admin_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'admin_comment_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Comment $comment, CommentRepository $commentRepository): Response
    {

        $commentRepository->remove($comment, true);

        return $this->redirectToRoute('admin_comment_index', [], Response::HTTP_SEE_OTHER);
    }
}