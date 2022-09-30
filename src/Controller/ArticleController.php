<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\Type\CommentType;
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

        // dés que le commenatire sera créé créé, il aura un article associé
        $comment = new Comment($article);

        //Pour voir le rendu
        $commentForm = $this->createForm(CommentType::class, $comment);

        return $this->renderForm('article/show.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm
        ]);
    }
}
