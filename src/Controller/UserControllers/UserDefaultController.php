<?php

namespace App\Controller\UserControllers;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserDefaultController extends AbstractController
{
    #[Route('/user', name: 'user_index')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        return $this->render('/user/index.html.twig', [
            'text' => 'Dashboard User',
         ]);
    }
}