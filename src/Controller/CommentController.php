<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/ajax/comments', name: 'comment_add')]
    public function add(Request $request, ArticleRepository $articleRepo, CommentRepository $commentRepo, EntityManagerInterface $em, UserRepository $userRepo): Response
    {
        $commentData = $request->request->all('comment');
    
        if(!$this->isCsrfTokenValid('comment-add', $commentData['_token'])) {
            return $this->json([
                'code'=> 'INVALID_CSRF_TOKEN'
            ], Response::HTTP_BAD_REQUEST );
        }

        // si tout est bon
        $article = $articleRepo->findOneBy(['id'=> $commentData['article']]);

        //si je ne trouve pas d'article
        if(!$article) {
            return $this -> json([
                'code'=> 'ARTICLE_NOT_FOUND'
            ], Response::HTTP_BAD_REQUEST);
        }

        //on créé notre objet commentaire
        $comment = new Comment($article);
        $comment->setContent($commentData['content']);
        $comment->setUser($userRepo->findOneBy(['id' => 1]));
        $comment->setCreatedAt(new \DateTime());

        // on persiste et on insère dans notre table de BDD
        $em->persist($comment);
        $em->flush();

        //on utilise la méhtode renderView pour avoir la vue
        $html = $this->renderView('comment/index.html.twig', [
            'comment' => $comment
        ]);

        // on retourne le html en Json
        return $this->json([
            'code' => 'COMMENT_ADDED_SUCCESSFULLY',
            'message' => $html,
            'numberOfComments' => $commentRepo->count(['article'=>$article])
        ]);
    }
}
