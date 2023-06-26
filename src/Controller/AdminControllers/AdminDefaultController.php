<?php

namespace App\Controller\AdminControllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDefaultController extends AbstractController
{
    #[Route('/admin', name: 'admin_index')]
    public function index(): Response
    {
        return $this->render('/admin/index.html.twig', [
            'text' => 'Dashboard Admin',
         ]);
    }
}