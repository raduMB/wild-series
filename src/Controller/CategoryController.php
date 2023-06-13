<?php

namespace App\Controller;

use App\Repository\ProgramRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/category', name: 'category_', methods: ['GET'])]

class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/{categoryName}', name: 'show', methods: ['GET'])]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        if (!$categoryRepository->findOneBy(['name' => $categoryName])) 
        {
            throw $this->createNotFoundException(
                'La catégorie' . ' ' . $categoryName . ' ' . 'n\'existe pas'
            );
        } else {
            $categories = $categoryRepository->findOneBy(['name' => $categoryName]);
            $programs = $programRepository->findBy(['category' => $categories], ['id' => 'DESC'], 3);
        }

        return $this->render('category/show.html.twig', [
            'categories' => $categories,
            'programs' => $programs,
        ]);
    }
}