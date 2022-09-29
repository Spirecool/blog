<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article/{slug}', name: 'article_show')]
    public function show(?Article $article): Response
    {
        //si l'URL de l'article n'existe pas, on retourne à la page d'accueil
        if(!$article) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }
}
