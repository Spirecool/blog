<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/{slug}', name: 'category_show')]
    public function show(?Category $category): Response
    {
         //si l'URL de l'article n'existe pas, on retourne à la page d'accueil
         if(!$category) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('category/show.html.twig', ['category' => $category]);
    }
}
