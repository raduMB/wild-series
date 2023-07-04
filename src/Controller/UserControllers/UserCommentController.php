<?php

namespace App\Controller\UserControllers;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\EpisodeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/user/comment')]
#[IsGranted('ROLE_CONTRIBUTOR')]

class UserCommentController extends AbstractController
{
    #[Route('/', name: 'user_comment_index', methods: ['GET'])]
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('user/comment/index.html.twig', [
          'comments' => $commentRepository->findAll(),
       ]);
    }

    #[Route('/new/{id}', name: 'user_comment_new', methods: ['GET', 'POST'])]
    public function new(int $id, Request $request, CommentRepository $commentRepository, EpisodeRepository $episodeRepository, TokenStorageInterface $tokenStorage) : Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $tokenStorage->getToken()->getUser();
            $episode = $episodeRepository->find($id);
            $comment->setAuthor($user);
            $comment->setEpisode($episode);
            $comment->setOwner($this->getUser());
            $commentRepository->save($comment, true);
            $this->addFlash('success', 'The new comment has been created');

            return $this->redirectToRoute('app_program_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_comment_show', methods: ['GET'])]
    public function show(Comment $comment): Response
    {
        return $this->render('user/comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    #[Route('/{id}/edit', name: 'user_comment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comment $comment, CommentRepository $commentRepository): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser() !== $comment->getOwner()) {
                // If not the owner, throws a 403 Access Denied exception
                throw $this->createAccessDeniedException('Only the owner can edit the comment!');
            }
            $commentRepository->save($comment, true);

            return $this->redirectToRoute('user_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'user_comment_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Comment $comment, CommentRepository $commentRepository): Response
    {
        if ($this->getUser() !== $comment->getOwner()) {
            // If not the owner, throws a 403 Access Denied exception
            throw $this->createAccessDeniedException('Only the owner can delete the comment!');
        }
        $commentRepository->remove($comment, true);

        return $this->redirectToRoute('user_comment_index', [], Response::HTTP_SEE_OTHER);
    }
}