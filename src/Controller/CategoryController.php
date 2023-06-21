<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/new', name: 'new', methods: ['POST'])]
    public function new(Request $request, CategoryRepository $categoryRepository) : Response
    {
        // Create a new Category Object
        $category = new Category();

        // Create the form, linked with $category
        $form = $this->createForm(CategoryType::class, $category);

        // Get data from HTTP request
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $categoryRepository->save($category, true);

            // Redirect to categories list
            return $this->redirectToRoute('category_index');
        }

        // Render the form
        return $this->render('category/new.html.twig', [
            'form' => $form->createView(),
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