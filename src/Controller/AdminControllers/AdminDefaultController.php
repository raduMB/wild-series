<?php

namespace App\Controller\AdminControllers;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AdminDefaultController extends AbstractController
{
    #[Route('/admin', name: 'admin_index')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('/admin/index.html.twig', [
            'text' => 'Dashboard Admin',
         ]);
    }
}